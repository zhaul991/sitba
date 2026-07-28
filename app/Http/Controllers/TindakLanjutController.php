<?php

namespace App\Http\Controllers;

use App\Models\Temuan;
use App\Models\TindakLanjut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TindakLanjutController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'temuan_id' => ['required', 'exists:temuans,id'],
        ]);

        $temuan = Temuan::with('inspeksi.bandara')
            ->findOrFail($request->temuan_id);

        return view('tindaklanjut.create', compact('temuan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'temuan_id' => ['required', 'exists:temuans,id'],
            'rencana_perbaikan' => ['required', 'string'],
            'pic' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'status' => [
                'required',
                Rule::in([
                    'Open',
                    'Dalam Tindak Lanjut',
                    'Selesai',
                ]),
            ],
            'catatan' => ['nullable', 'string'],
        ], [
            'temuan_id.required' => 'Data temuan wajib tersedia.',
            'temuan_id.exists' => 'Data temuan tidak valid.',
            'rencana_perbaikan.required' => 'Rencana perbaikan wajib diisi.',
            'pic.required' => 'PIC wajib diisi.',
            'deadline.required' => 'Batas waktu wajib diisi.',
            'deadline.date' => 'Format batas waktu tidak valid.',
            'status.required' => 'Status tindak lanjut wajib dipilih.',
            'status.in' => 'Status tindak lanjut tidak valid.',
        ]);

        TindakLanjut::create($validated);

        return redirect()
            ->route('temuan.show', $validated['temuan_id'])
            ->with(
                'success',
                'Tindak lanjut berhasil ditambahkan. Status Temuan tidak berubah otomatis.'
            );
    }

    public function edit(TindakLanjut $tindakLanjut)
    {
        $tindakLanjut->load('temuan.inspeksi.bandara');

        return view('tindaklanjut.edit', compact('tindakLanjut'));
    }

    public function update(
        Request $request,
        TindakLanjut $tindakLanjut
    ) {
        $validated = $request->validate([
            'rencana_perbaikan' => ['required', 'string'],
            'pic' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'status' => [
                'required',
                Rule::in([
                    'Open',
                    'Dalam Tindak Lanjut',
                    'Selesai',
                ]),
            ],
            'catatan' => ['nullable', 'string'],
        ]);

        $tindakLanjut->update($validated);

        return redirect()
            ->route('temuan.show', $tindakLanjut->temuan_id)
            ->with(
                'success',
                'Tindak lanjut berhasil diperbarui. Status Temuan tidak berubah otomatis.'
            );
    }

    public function destroy(TindakLanjut $tindakLanjut)
    {
        $temuanId = $tindakLanjut->temuan_id;

        $tindakLanjut->delete();

        return redirect()
            ->route('temuan.show', $temuanId)
            ->with('success', 'Tindak lanjut berhasil dihapus.');
    }
}
