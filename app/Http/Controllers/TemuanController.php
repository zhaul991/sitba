<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Inspeksi;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TemuanController extends Controller
{
    public function index(Request $request)
    {
        /*
         * Mendukung pencarian dari:
         * - Form halaman Temuan: ?keyword=...
         * - Global Search SITBA: ?q=...
         */
        $keyword = trim((string) $request->query(
            'keyword',
            $request->query('q', '')
        ));

        $status = $request->query('status');
        $tingkatRisiko = $request->query('tingkat_risiko');

        $tahun = $request->filled('tahun')
            ? $request->integer('tahun')
            : null;

        $bandaraId = $request->filled('bandara_id')
            ? $request->integer('bandara_id')
            : null;

        $queryTemuan = Temuan::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query
                        ->where(
                            'nomor_temuan',
                            'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'uraian_temuan',
                            'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'unsur_elemen',
                            'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'lokasi',
                            'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhereHas(
                            'inspeksi.bandara',
                            function ($query) use ($keyword) {
                                $query
                                    ->where(
                                        'nama_bandara',
                                        'like',
                                        '%' . $keyword . '%'
                                    )
                                    ->orWhere(
                                        'kode_bandara',
                                        'like',
                                        '%' . $keyword . '%'
                                    );
                            }
                        );
                });
            })
            ->when($bandaraId, function ($query, $bandaraId) {
                $query->whereHas(
                    'inspeksi',
                    function ($query) use ($bandaraId) {
                        $query->where('bandara_id', $bandaraId);
                    }
                );
            })
            ->when($tahun, function ($query, $tahun) {
                $query->whereHas(
                    'inspeksi',
                    function ($query) use ($tahun) {
                        $query->whereYear('tanggal', $tahun);
                    }
                );
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($tingkatRisiko, function ($query, $tingkatRisiko) {
                $query->where('tingkat_risiko', $tingkatRisiko);
            });

        $totalTemuan = (clone $queryTemuan)->count();

        $totalOpen = (clone $queryTemuan)
            ->where('status', 'Open')
            ->count();

        $totalClose = (clone $queryTemuan)
            ->where('status', 'Close')
            ->count();

        $totalRisikoTinggi = (clone $queryTemuan)
            ->where('tingkat_risiko', 'Tinggi')
            ->count();

        $temuans = (clone $queryTemuan)
            ->with([
                'inspeksi.bandara',
                'foto',
                'tindakLanjut',
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $daftarBandara = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        $daftarTahun = Inspeksi::query()
            ->whereNotNull('tanggal')
            ->selectRaw('DISTINCT strftime("%Y", tanggal) AS tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->filter()
            ->values();

        return view('temuan.index', compact(
            'temuans',
            'daftarBandara',
            'daftarTahun',
            'totalTemuan',
            'totalOpen',
            'totalClose',
            'totalRisikoTinggi'
        ));
    }

    public function create(Request $request)
    {
        $bandaras = Bandara::orderBy('nama_bandara')
            ->get();

        $inspeksiTerpilih = $request->inspeksi_id;

        return view('temuan.create', compact(
            'bandaras',
            'inspeksiTerpilih'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateTemuan($request);

        $validated = $this->normalisasiDataPenutupan($validated);

        $temuan = Temuan::create($validated);

        return redirect()
            ->route('temuan.show', $temuan)
            ->with('success', 'Data temuan berhasil ditambahkan.');
    }

    public function show(Temuan $temuan)
{
    $temuan->load([
    'inspeksi.bandara',
    'inspeksi.petugas',
    'foto',
    'tindakLanjut',
    'laporans.bandara',
]);

    return view('temuan.show', compact('temuan'));
}

    public function edit(Temuan $temuan)
    {
        $inspeksis = Inspeksi::with('bandara')
            ->latest('tanggal')
            ->get();

        return view('temuan.edit', compact(
            'temuan',
            'inspeksis'
        ));
    }

    public function update(Request $request, Temuan $temuan)
    {
        $validated = $this->validateTemuan($request, $temuan);

        $validated = $this->normalisasiDataPenutupan($validated);

        $temuan->update($validated);

        return redirect()
            ->route('temuan.show', $temuan)
            ->with('success', 'Data temuan berhasil diperbarui.');
    }

    public function destroy(Temuan $temuan)
    {
        $inspeksiId = $temuan->inspeksi_id;

        $temuan->delete();

        return redirect()
            ->route('inspeksi.show', $inspeksiId)
            ->with('success', 'Data temuan berhasil dihapus.');
    }



    public function getTahunInspeksi($bandara)
    {
        return Inspeksi::where('bandara_id', $bandara)
            ->whereNotNull('tanggal')
            ->selectRaw('DISTINCT strftime("%Y", tanggal) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');
    }


    public function getBulanInspeksi($bandara, $tahun)
    {
        return Inspeksi::where('bandara_id', $bandara)
            ->whereYear('tanggal', $tahun)
            ->whereNotNull('tanggal')
            ->selectRaw('DISTINCT strftime("%m", tanggal) as bulan')
            ->orderBy('bulan')
            ->pluck('bulan');
    }


    public function getListInspeksi($bandara, $tahun, $bulan)
    {
        return Inspeksi::with('bandara')
            ->where('bandara_id', $bandara)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get()
            ->map(function ($inspeksi) {

                return [
                    'id' => $inspeksi->id,
                    'tanggal' => $inspeksi->tanggal->format('d-m-Y'),
                ];

            });
    }


    private function validateTemuan(
        Request $request,
        ?Temuan $temuan = null
    ): array {
        return $request->validate([
            'inspeksi_id' => [
                'required',
                'exists:inspeksis,id',
            ],

            'nomor_temuan' => [
                'required',
                'string',
                'max:255',
                Rule::unique(
                    'temuans',
                    'nomor_temuan'
                )
                    ->where(
                        fn ($query) => $query->where(
                            'inspeksi_id',
                            $request->inspeksi_id
                        )
                    )
                    ->ignore($temuan?->id),
            ],

            'uraian_temuan' => [
                'required',
                'string',
            ],

            'unsur_elemen' => [
                'required',
                'string',
                'max:255',
            ],

            'tingkat_risiko' => [
                'required',
                Rule::in([
                    'Rendah',
                    'Tinggi',
                ]),
            ],

            'lokasi' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Open',
                    'Close',
                ]),
            ],

            'tanggal_close' => [
                'nullable',
                'required_if:status,Close',
                'date',
            ],

            'keterangan_penutupan' => [
                'nullable',
                'required_if:status,Close',
                'string',
                'max:3000',
            ],
        ], [
            'inspeksi_id.required' =>
                'Data inspeksi wajib dipilih.',

            'inspeksi_id.exists' =>
                'Data inspeksi yang dipilih tidak valid.',

            'nomor_temuan.required' =>
                'Nomor temuan wajib diisi.',

            'nomor_temuan.unique' =>
                'Nomor temuan sudah digunakan.',

            'uraian_temuan.required' =>
                'Uraian temuan wajib diisi.',

            'unsur_elemen.required' =>
                'Unsur atau elemen wajib diisi.',

            'tingkat_risiko.required' =>
                'Tingkat risiko wajib dipilih.',

            'tingkat_risiko.in' =>
                'Tingkat risiko tidak valid.',

            'lokasi.required' =>
                'Lokasi temuan wajib diisi.',

            'status.required' =>
                'Status temuan wajib dipilih.',

            'status.in' =>
                'Status temuan harus Open atau Close.',

            'tanggal_close.required_if' =>
                'Tanggal penutupan wajib diisi untuk temuan Close.',

            'tanggal_close.date' =>
                'Format tanggal penutupan tidak valid.',

            'keterangan_penutupan.required_if' =>
                'Keterangan penutupan wajib diisi untuk temuan Close.',

            'keterangan_penutupan.max' =>
                'Keterangan penutupan maksimal 3.000 karakter.',
        ]);
    }

    private function normalisasiDataPenutupan(
        array $validated
    ): array {
        if ($validated['status'] === 'Open') {
            $validated['tanggal_close'] = null;
            $validated['keterangan_penutupan'] = null;
        }

        return $validated;
    }
}
