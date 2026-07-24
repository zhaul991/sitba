<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query()
            ->with('bandara')
            ->when(
                $request->filled('bandara_id'),
                fn ($query) => $query->where(
                    'bandara_id',
                    $request->bandara_id
                )
            )
            ->when(
                $request->filled('tahun'),
                fn ($query) => $query->whereYear(
                    'tanggal_surat',
                    $request->tahun
                )
            )
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where(
                    'nomor_surat',
                    'like',
                    '%' . $request->q . '%'
                )
            )
            ->latest('tanggal_surat');

        $laporans = $query
            ->paginate(10)
            ->withQueryString();

        $bandaras = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        $daftarTahun = Laporan::query()
            ->whereNotNull('tanggal_surat')
            ->pluck('tanggal_surat')
            ->map(
                fn ($tanggal) => \Carbon\Carbon::parse($tanggal)->year
            )
            ->unique()
            ->sortDesc()
            ->values();

        return view('laporan.index', compact(
            'laporans',
            'bandaras',
            'daftarTahun'
        ));
    }

    public function create()
    {
        $bandaras = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        return view('laporan.create', compact('bandaras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bandara_id' => [
                'required',
                'exists:bandaras,id',
            ],
            'nomor_surat' => [
                'required',
                'string',
                'max:255',
            ],
            'tanggal_surat' => [
                'required',
                'date',
            ],
            'perihal' => [
                'nullable',
                'string',
                'max:255',
            ],
            'keterangan' => [
                'nullable',
                'string',
            ],
            'file_surat' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ]);

        $validated['file_surat'] = $request
            ->file('file_surat')
            ->store('laporan', 'public');

        $laporan = Laporan::create($validated);

        return redirect()
            ->route('laporan.show', $laporan)
            ->with(
                'success',
                'Laporan tindak lanjut berhasil disimpan.'
            );
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('bandara');

        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        $bandaras = Bandara::query()
            ->orderBy('nama_bandara')
            ->get();

        return view(
            'laporan.edit',
            compact('laporan', 'bandaras')
        );
    }

    public function update(
        Request $request,
        Laporan $laporan
    ) {
        $validated = $request->validate([
            'bandara_id' => [
                'required',
                'exists:bandaras,id',
            ],
            'nomor_surat' => [
                'required',
                'string',
                'max:255',
            ],
            'tanggal_surat' => [
                'required',
                'date',
            ],
            'perihal' => [
                'nullable',
                'string',
                'max:255',
            ],
            'keterangan' => [
                'nullable',
                'string',
            ],
            'file_surat' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ]);

        if ($request->hasFile('file_surat')) {
            if (
                $laporan->file_surat
                && Storage::disk('public')
                    ->exists($laporan->file_surat)
            ) {
                Storage::disk('public')
                    ->delete($laporan->file_surat);
            }

            $validated['file_surat'] = $request
                ->file('file_surat')
                ->store('laporan', 'public');
        }

        $laporan->update($validated);

        return redirect()
            ->route('laporan.show', $laporan)
            ->with(
                'success',
                'Laporan tindak lanjut berhasil diperbarui.'
            );
    }

    public function destroy(Laporan $laporan)
    {
        if (
            $laporan->file_surat
            && Storage::disk('public')
                ->exists($laporan->file_surat)
        ) {
            Storage::disk('public')
                ->delete($laporan->file_surat);
        }

        $laporan->delete();

        return redirect()
            ->route('laporan.index')
            ->with(
                'success',
                'Laporan tindak lanjut berhasil dihapus.'
            );
    }
}
