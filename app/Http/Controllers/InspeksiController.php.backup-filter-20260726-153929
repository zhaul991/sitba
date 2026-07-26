<?php

namespace App\Http\Controllers;

use App\Models\Bandara;
use App\Models\Inspeksi;
use App\Models\Petugas;
use Illuminate\Http\Request;

class InspeksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $inspeksis = Inspeksi::with(['bandara', 'petugas'])
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('keterangan', 'like', '%' . $keyword . '%')
                        ->orWhereHas('bandara', function ($query) use ($keyword) {
                            $query->where('nama_bandara', 'like', '%' . $keyword . '%')
                                ->orWhere('kode_bandara', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('petugas', function ($query) use ($keyword) {
                            $query->where('nama_petugas', 'like', '%' . $keyword . '%')
                                ->orWhere('nip', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('inspeksi.index', compact('inspeksis'));
    }

    public function create()
    {
        $bandaras = Bandara::orderBy('nama_bandara')->get();
        $petugas = Petugas::orderBy('nama_petugas')->get();

        return view('inspeksi.create', compact('bandaras', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bandara_id' => ['required', 'exists:bandaras,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
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
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        $inspeksi->petugas()->sync($validated['petugas']);

        return redirect()
            ->route('inspeksi.index')
            ->with('success', 'Data inspeksi berhasil ditambahkan.');
    }

    public function show(Inspeksi $inspeksi)
    {
        $inspeksi->load(['bandara', 'petugas', 'temuans']);

        return view('inspeksi.show', compact('inspeksi'));
    }

    public function edit(Inspeksi $inspeksi)
    {
        $bandaras = Bandara::orderBy('nama_bandara')->get();
        $petugas = Petugas::orderBy('nama_petugas')->get();

        $inspeksi->load('petugas');

        return view('inspeksi.edit', compact(
            'inspeksi',
            'bandaras',
            'petugas'
        ));
    }

    public function update(Request $request, Inspeksi $inspeksi)
    {
        $validated = $request->validate([
            'bandara_id' => ['required', 'exists:bandaras,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
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
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        $inspeksi->petugas()->sync($validated['petugas']);

        return redirect()
            ->route('inspeksi.index')
            ->with('success', 'Data inspeksi berhasil diperbarui.');
    }

    public function destroy(Inspeksi $inspeksi)
    {
        $inspeksi->delete();

        return redirect()
            ->route('inspeksi.index')
            ->with('success', 'Data inspeksi berhasil dihapus.');
    }
}
