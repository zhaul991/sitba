<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use Illuminate\Http\Request;

class BandaraController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $bandaras = Bandara::when($keyword, function ($query) use ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('nama_bandara', 'like', "%{$keyword}%")
                    ->orWhere('kode_bandara', 'like', "%{$keyword}%")
                    ->orWhere('lokasi', 'like', "%{$keyword}%");
            });
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('bandara.index', compact('bandaras'));
    }

    public function create()
    {
        return view('bandara.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bandara' => ['required', 'string', 'max:255'],
            'kode_bandara' => ['required', 'string', 'max:20', 'unique:bandaras,kode_bandara'],
            'lokasi' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ]);

        Bandara::create($validated);

        return redirect()
            ->route('bandara.index')
            ->with('success', 'Data bandara berhasil ditambahkan.');
    }

    public function show(Bandara $bandara)
    {
        $jumlahInspeksi = $bandara
            ->inspeksis()
            ->count();

        $totalTemuan = $bandara
            ->inspeksis()
            ->withCount('temuans')
            ->get()
            ->sum('temuans_count');

        $temuanOpen = $bandara
            ->inspeksis()
            ->whereHas('temuans', function ($query) {
                $query->where('status', 'Open');
            })
            ->withCount([
                'temuans as temuan_open_count' => function ($query) {
                    $query->where('status', 'Open');
                },
            ])
            ->get()
            ->sum('temuan_open_count');

        $temuanClose = $bandara
            ->inspeksis()
            ->whereHas('temuans', function ($query) {
                $query->where('status', 'Close');
            })
            ->withCount([
                'temuans as temuan_close_count' => function ($query) {
                    $query->where('status', 'Close');
                },
            ])
            ->get()
            ->sum('temuan_close_count');

        $inspeksiTerakhir = $bandara
            ->inspeksis()
            ->latest('tanggal')
            ->first();

        $inspeksiTerbaru = $bandara
            ->inspeksis()
            ->with('petugas')
            ->withCount('temuans')
            ->latest('tanggal')
            ->limit(5)
            ->get();

        $temuanTerbaru = \App\Models\Temuan::query()
            ->with('inspeksi')
            ->whereHas('inspeksi', function ($query) use ($bandara) {
                $query->where('bandara_id', $bandara->id);
            })
            ->latest()
            ->limit(5)
            ->get();

        return view('bandara.show', compact(
            'bandara',
            'jumlahInspeksi',
            'totalTemuan',
            'temuanOpen',
            'temuanClose',
            'inspeksiTerakhir',
            'inspeksiTerbaru',
            'temuanTerbaru'
        ));
    }

    public function edit(Bandara $bandara)
    {
        return view('bandara.edit', compact('bandara'));
    }

    public function update(Request $request, Bandara $bandara)
    {
        $validated = $request->validate([
            'nama_bandara' => ['required', 'string', 'max:255'],
            'kode_bandara' => [
                'required',
                'string',
                'max:20',
                'unique:bandaras,kode_bandara,' . $bandara->id,
            ],
            'lokasi' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ]);

        $bandara->update($validated);

        return redirect()
            ->route('bandara.index')
            ->with('success', 'Data bandara berhasil diperbarui.');
    }

    public function destroy(Bandara $bandara)
    {
        $bandara->delete();

        return redirect()
            ->route('bandara.index')
            ->with('success', 'Data bandara berhasil dihapus.');
    }
}