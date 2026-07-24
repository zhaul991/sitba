@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    @php
        $risikoClass = match ($temuan->tingkat_risiko) {
            'Rendah' => 'bg-green-50 text-green-700 border-green-200',
            'Tinggi' => 'bg-orange-50 text-orange-700 border-orange-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };

        $statusClass = match ($temuan->status) {
            'Open' => 'bg-red-50 text-red-700 border-red-200',
            'Close' => 'bg-green-50 text-green-700 border-green-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    @endphp

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Detail Temuan
            </h1>

            <p class="mt-2 text-gray-500">
                Informasi lengkap temuan hasil inspeksi bandar udara.
            </p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">

            <a href="{{ route('temuan.index') }}"
               class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                Kembali
            </a>

            <a href="{{ route('temuan.edit', $temuan) }}"
               class="rounded-xl bg-amber-500 px-5 py-3 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                Edit Temuan
            </a>

        </div>

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        <div class="space-y-6 lg:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Nomor Temuan
                        </p>

                        <h2 class="mt-2 text-2xl font-bold text-gray-800">
                            {{ $temuan->nomor_temuan }}
                        </h2>
                    </div>

                    <div class="flex flex-wrap gap-2">

                        <span class="rounded-lg border px-3 py-1 text-sm font-semibold {{ $risikoClass }}">
                            Risiko: {{ $temuan->tingkat_risiko }}
                        </span>

                        <span class="rounded-lg border px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                            {{ $temuan->status }}
                        </span>

                    </div>

                </div>

                <div class="mt-6 border-t border-gray-100 pt-6">

                    <p class="text-sm font-semibold text-gray-500">
                        Uraian Temuan
                    </p>

                    <p class="mt-2 whitespace-pre-line leading-relaxed text-gray-700">
                        {{ $temuan->uraian_temuan }}
                    </p>

                </div>

                <div class="mt-6 grid gap-6 border-t border-gray-100 pt-6 sm:grid-cols-2">

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Unsur / Elemen
                        </p>

                        <p class="mt-2 font-semibold text-gray-800">
                            {{ $temuan->unsur_elemen }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Lokasi
                        </p>

                        <p class="mt-2 font-semibold text-gray-800">
                            {{ $temuan->lokasi }}
                        </p>
                    </div>

                </div>

            </div>

            @if ($temuan->status === 'Close')
                <div class="rounded-2xl border border-green-200 bg-green-50 p-6 shadow-sm">

                    <div class="flex items-start gap-4">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-100 text-2xl">
                            ✓
                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-bold uppercase tracking-wide text-green-700">
                                Temuan Ditutup
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-green-900">
                                Seluruh dokumen telah diverifikasi.
                            </h2>

                            <div class="mt-5 grid gap-5 border-t border-green-200 pt-5 sm:grid-cols-2">

                                <div>
                                    <p class="text-sm font-semibold text-green-700">
                                        Tanggal Penutupan
                                    </p>

                                    <p class="mt-2 font-bold text-green-900">
                                        {{ $temuan->tanggal_close?->format('d-m-Y') ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-green-700">
                                        Status
                                    </p>

                                    <span class="mt-2 inline-flex rounded-lg border border-green-300 bg-white px-3 py-1 text-sm font-bold text-green-800">
                                        Close
                                    </span>
                                </div>

                            </div>

                            @if ($temuan->keterangan_penutupan)
                                <div class="mt-5 border-t border-green-200 pt-5">

                                    <p class="text-sm font-semibold text-green-700">
                                        Keterangan Penutupan
                                    </p>

                                    <p class="mt-2 whitespace-pre-line leading-relaxed text-green-900">
                                        {{ $temuan->keterangan_penutupan }}
                                    </p>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            @endif

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Tindak Lanjut
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Riwayat tindak lanjut terhadap temuan ini.
                        </p>
                    </div>

                    <a href="{{ route('tindaklanjut.create', ['temuan_id' => $temuan->id]) }}"
                       class="rounded-xl bg-blue-600 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                        + Tambah Tindak Lanjut
                    </a>

                </div>

                <div class="mt-6 space-y-3">

                    @forelse ($temuan->tindakLanjut as $item)

                        @php
                            $statusTindakLanjutClass = match ($item->status) {
                                'Open' => 'bg-red-50 text-red-700',
                                'Dalam Tindak Lanjut' => 'bg-blue-50 text-blue-700',
                                'Selesai' => 'bg-green-50 text-green-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <div class="rounded-xl border border-gray-200 p-4">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="flex-1">

                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="rounded-lg px-3 py-1 text-xs font-semibold {{ $statusTindakLanjutClass }}">
                                            {{ $item->status }}
                                        </span>

                                        <span class="text-sm text-gray-500">
                                            Deadline:
                                            {{ $item->deadline?->format('d-m-Y') ?? '-' }}
                                        </span>
                                    </div>

                                    <p class="mt-3 font-semibold text-gray-800">
                                        {{ $item->rencana_perbaikan }}
                                    </p>

                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-semibold">PIC:</span>
                                        {{ $item->pic }}
                                    </p>

                                    @if ($item->catatan)
                                        <p class="mt-2 text-sm text-gray-500">
                                            {{ $item->catatan }}
                                        </p>
                                    @endif

                                </div>

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('tindaklanjut.edit', $item) }}"
                                        class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('tindaklanjut.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus tindak lanjut ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-gray-300 px-5 py-10 text-center">

                            <div class="text-4xl">
                                🛠️
                            </div>

                            <p class="mt-3 font-semibold text-gray-700">
                                Belum ada tindak lanjut
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Tindak lanjut terhadap temuan ini akan tampil di bagian ini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Foto Bukti
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Dokumentasi foto kondisi temuan.
                        </p>
                    </div>

                    <a href="{{ route('fototemuan.create', ['temuan_id' => $temuan->id]) }}"
                       class="rounded-xl bg-gray-900 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-gray-700">
                        + Tambah Foto
                    </a>

                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">

                    @forelse ($temuan->foto as $foto)

                        <div class="overflow-hidden rounded-xl border border-gray-200">

                            <img
                                src="{{ asset('storage/foto-temuan/' . $foto->nama_file) }}"
                                alt="Foto temuan {{ $temuan->nomor_temuan }}"
                                class="h-56 w-full object-cover"
                            >

                            <div class="p-4">

                                <p class="text-sm text-gray-600">
                                    {{ $foto->keterangan ?: 'Tanpa keterangan.' }}
                                </p>

                                <form
                                    action="{{ route('fototemuan.destroy', $foto) }}"
                                    method="POST"
                                    class="mt-4"
                                    onsubmit="return confirm('Yakin ingin menghapus foto ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-sm font-semibold text-red-600 transition hover:text-red-800"
                                    >
                                        Hapus Foto
                                    </button>
                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-gray-300 px-5 py-10 text-center sm:col-span-2">

                            <div class="text-4xl">
                                📷
                            </div>

                            <p class="mt-3 font-semibold text-gray-700">
                                Belum ada foto
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Foto bukti temuan akan tampil di bagian ini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="space-y-6">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-gray-800">
                    Informasi Inspeksi
                </h2>

                <div class="mt-6 space-y-5">

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Bandara
                        </p>

                        <p class="mt-2 font-bold text-gray-800">
                            {{ $temuan->inspeksi?->bandara?->nama_bandara ?? '-' }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $temuan->inspeksi?->bandara?->kode_bandara ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Tanggal Inspeksi
                        </p>

                        <p class="mt-2 font-semibold text-gray-800">
                            {{ $temuan->inspeksi?->tanggal?->format('d-m-Y') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Tim Inspektur
                        </p>

                        <div class="mt-2 flex flex-wrap gap-2">

                            @forelse ($temuan->inspeksi?->petugas ?? [] as $inspektur)

                                <span class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $inspektur->nama_petugas }}
                                </span>

                            @empty

                                <span class="text-sm text-gray-500">
                                    Belum tersedia
                                </span>

                            @endforelse

                        </div>
                    </div>

                </div>

                <a href="{{ route('inspeksi.show', $temuan->inspeksi_id) }}"
                   class="mt-6 block rounded-xl border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                    Lihat Detail Inspeksi
                </a>

            </div>

            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6">

                <p class="text-sm font-semibold text-blue-700">
                    ID Temuan
                </p>

                <p class="mt-2 text-2xl font-bold text-blue-900">
                    #{{ $temuan->id }}
                </p>

                <p class="mt-3 text-sm text-blue-700">
                    Dibuat pada {{ $temuan->created_at?->format('d-m-Y H:i') ?? '-' }}
                </p>

            </div>

            <form
                action="{{ route('temuan.destroy', $temuan) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus temuan ini?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="w-full rounded-xl bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                    Hapus Temuan
                </button>
            </form>

        </div>

    </div>

</div>
@endsection
