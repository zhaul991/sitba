<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $petugas = Petugas::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('nama_petugas', 'like', '%' . $keyword . '%')
                        ->orWhere('nip', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_petugas' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:30', 'unique:petugas,nip'],
        ]);

        Petugas::create($validated);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data inspektur berhasil ditambahkan.');
    }

    public function show(Petugas $petuga)
    {
        return redirect()->route('petugas.edit', [
            'petuga' => $petuga->id,
        ]);
    }

    public function edit(Petugas $petuga)
    {
        return view('petugas.edit', [
            'petugas' => $petuga,
        ]);
    }

    public function update(Request $request, Petugas $petuga)
    {
        $validated = $request->validate([
            'nama_petugas' => ['required', 'string', 'max:255'],
            'nip' => [
                'required',
                'string',
                'max:30',
                Rule::unique('petugas', 'nip')->ignore($petuga->id),
            ],
        ]);

        $petuga->update($validated);

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data inspektur berhasil diperbarui.');
    }

    public function destroy(Petugas $petuga)
    {
        $petuga->delete();

        return redirect()
            ->route('petugas.index')
            ->with('success', 'Data inspektur berhasil dihapus.');
    }
}
