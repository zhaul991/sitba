<?php

namespace App\Http\Controllers;

use App\Models\FotoTemuan;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FotoTemuanController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'temuan_id' => ['required', 'exists:temuans,id'],
        ]);

        $temuan = Temuan::with('inspeksi.bandara')
            ->findOrFail($request->temuan_id);

        return view('fototemuan.create', compact('temuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'temuan_id' => ['required', 'exists:temuans,id'],
            'foto' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'temuan_id.required' => 'Data temuan wajib tersedia.',
            'temuan_id.exists' => 'Data temuan tidak valid.',
            'foto.required' => 'Foto bukti wajib dipilih.',
            'foto.image' => 'File yang dipilih harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 5 MB.',
            'keterangan.max' => 'Keterangan maksimal 1.000 karakter.',
        ]);

        $file = $request->file('foto');

        $namaFile = now()->format('YmdHis')
            . '_'
            . Str::uuid()
            . '.'
            . $file->getClientOriginalExtension();

        $file->storeAs(
            'foto-temuan',
            $namaFile,
            'public'
        );

        FotoTemuan::create([
            'temuan_id' => $validated['temuan_id'],
            'nama_file' => $namaFile,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('temuan.show', $validated['temuan_id'])
            ->with('success', 'Foto bukti berhasil ditambahkan.');
    }

    public function destroy(FotoTemuan $fototemuan)
    {
        $temuanId = $fototemuan->temuan_id;

        if (
            $fototemuan->nama_file &&
            Storage::disk('public')->exists(
                'foto-temuan/' . $fototemuan->nama_file
            )
        ) {
            Storage::disk('public')->delete(
                'foto-temuan/' . $fototemuan->nama_file
            );
        }

        $fototemuan->delete();

        return redirect()
            ->route('temuan.show', $temuanId)
            ->with('success', 'Foto bukti berhasil dihapus.');
    }
}
