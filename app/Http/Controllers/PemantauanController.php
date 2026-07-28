<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Inspeksi;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PemantauanController extends Controller
{
    private const JENIS_KEGIATAN = 'Pemantauan (Monitoring)';
    public function index(Request $request)
    {
        /*
         * Mendukung:
         * - Form Inspeksi: ?keyword=...
         * - Global Search: ?q=...
         */
        $keyword = trim((string) $request->query(
            'keyword',
            $request->query('q', '')
        ));

        $bandaraId = $request->filled('bandara_id')
            ? $request->integer('bandara_id')
            : null;

        $petugasId = $request->filled('petugas_id')
            ? $request->integer('petugas_id')
            : null;

        $tahun = $request->filled('tahun')
            ? $request->integer('tahun')
            : null;

        $queryInspeksi = Inspeksi::query()->where('jenis_inspeksi', self::JENIS_KEGIATAN)
            ->with([
                'bandara',
                'petugas',
            ])
            ->when(
                $keyword !== '',
                function ($query) use ($keyword) {
                    $query->where(
                        function ($searchQuery) use ($keyword) {
                            $searchQuery
                                ->where(
                                    'jenis_inspeksi',
                                    'like',
                                    "%{$keyword}%"
                                )
                                ->orWhereHas(
                                    'bandara',
                                    function ($bandaraQuery) use ($keyword) {
                                        $bandaraQuery
                                            ->where(
                                                'nama_bandara',
                                                'like',
                                                "%{$keyword}%"
                                            )
                                            ->orWhere(
                                                'kode_bandara',
                                                'like',
                                                "%{$keyword}%"
                                            );
                                    }
                                )
                                ->orWhereHas(
                                    'petugas',
                                    function ($petugasQuery) use ($keyword) {
                                        $petugasQuery
                                            ->where(
                                                'nama_petugas',
                                                'like',
                                                "%{$keyword}%"
                                            )
                                            ->orWhere(
                                                'nip',
                                                'like',
                                                "%{$keyword}%"
                                            );
                                    }
                                );
                        }
                    );
                }
            )
            ->when(
                $bandaraId,
                function ($query, $bandaraId) {
                    $query->where('bandara_id', $bandaraId);
                }
            )
            ->when(
                $petugasId,
                function ($query, $petugasId) {
                    $query->whereHas(
                        'petugas',
                        function ($petugasQuery) use ($petugasId) {
                            $petugasQuery->where(
                                'petugas.id',
                                $petugasId
                            );
                        }
                    );
                }
            )
            ->when(
                $tahun,
                function ($query, $tahun) {
                    $query->whereYear('tanggal', $tahun);
                }
            );

        $inspeksis = (clone $queryInspeksi)
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        $daftarBandara = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        $daftarPetugas = Petugas::query()
            ->orderBy('nama_petugas')
            ->get();

        $daftarTahun = Inspeksi::query()->where('jenis_inspeksi', self::JENIS_KEGIATAN)
            ->whereNotNull('tanggal')
            ->orderByDesc('tanggal')
            ->pluck('tanggal')
            ->map(function ($tanggal) {
                return \Illuminate\Support\Carbon::parse(
                    $tanggal
                )->year;
            })
            ->unique()
            ->values();

        return view('pemantauan.index', compact(
            'inspeksis',
            'daftarBandara',
            'daftarPetugas',
            'daftarTahun'
        ));
    }

    public function create()
    {
        $bandaras = Bandara::orderBy('nama_bandara')->get();
        $petugas = Petugas::orderBy('nama_petugas')->get();

        return view('pemantauan.create', compact('bandaras', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bandara_id' => ['required', 'exists:bandaras,id'],
            'tanggal' => ['required', 'date'],
            'jenis_inspeksi' => ['required', 'string'],
            'petugas' => ['required', 'array', 'min:1'],
            'petugas.*' => ['required', 'exists:petugas,id'],
        ], [
            'bandara_id.required' => 'Bandara wajib dipilih.',
            'bandara_id.exists' => 'Bandara yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal inspeksi wajib diisi.',
            'tanggal.date' => 'Format tanggal inspeksi tidak valid.',
            'petugas.required' => 'Pilih minimal satu inspektur.',
            'petugas.min' => 'Pilih minimal satu inspektur.',
        ]);

        $inspeksi = Inspeksi::create([
            'bandara_id' => $validated['bandara_id'],
            'tanggal' => $validated['tanggal'],
            'jenis_inspeksi' => self::JENIS_KEGIATAN,
        ]);

        $inspeksi->petugas()->sync($validated['petugas']);

        return redirect()
            ->route('pemantauan.index')
            ->with('success', 'Data pemantauan berhasil ditambahkan.');
    }

    public function show(Inspeksi $inspeksi)
    {
        abort_unless(
            $inspeksi->jenis_inspeksi === self::JENIS_KEGIATAN,
            404
        );

        $inspeksi->load(['bandara', 'petugas', 'temuans']);

        return view('pemantauan.show', compact('inspeksi'));
    }

    public function edit(Inspeksi $inspeksi)
    {
        abort_unless(
            $inspeksi->jenis_inspeksi === self::JENIS_KEGIATAN,
            404
        );

        $bandaras = Bandara::orderBy('nama_bandara')->get();
        $petugas = Petugas::orderBy('nama_petugas')->get();

        $inspeksi->load('petugas');

        return view('pemantauan.edit', compact(
            'inspeksi',
            'bandaras',
            'petugas'
        ));
    }

    public function update(Request $request, Inspeksi $inspeksi)
    {
        abort_unless(
            $inspeksi->jenis_inspeksi === self::JENIS_KEGIATAN,
            404
        );

        $validated = $request->validate([
            'bandara_id' => ['required', 'exists:bandaras,id'],
            'tanggal' => ['required', 'date'],
            'jenis_inspeksi' => ['required', 'string'],
            'petugas' => ['required', 'array', 'min:1'],
            'petugas.*' => ['required', 'exists:petugas,id'],
        ], [
            'bandara_id.required' => 'Bandara wajib dipilih.',
            'bandara_id.exists' => 'Bandara yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal inspeksi wajib diisi.',
            'tanggal.date' => 'Format tanggal inspeksi tidak valid.',
            'petugas.required' => 'Pilih minimal satu inspektur.',
            'petugas.min' => 'Pilih minimal satu inspektur.',
        ]);

        $inspeksi->update([
            'bandara_id' => $validated['bandara_id'],
            'tanggal' => $validated['tanggal'],
            'jenis_inspeksi' => self::JENIS_KEGIATAN,
        ]);

        $inspeksi->petugas()->sync($validated['petugas']);

        return redirect()
            ->route('pemantauan.index')
            ->with('success', 'Data pemantauan berhasil diperbarui.');
    }

    public function destroy(Inspeksi $inspeksi)
    {
        abort_unless(
            $inspeksi->jenis_inspeksi === self::JENIS_KEGIATAN,
            404
        );

        $inspeksi->delete();

        return redirect()
            ->route('pemantauan.index')
            ->with('success', 'Data pemantauan berhasil dihapus.');
    }
}
