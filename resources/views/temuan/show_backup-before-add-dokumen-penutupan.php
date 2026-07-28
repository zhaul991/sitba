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

            @php
    $laporan = $temuan->laporans->first();
@endphp

@if ($temuan->status === 'Close')

<div class="rounded-2xl border border-green-200 bg-green-50 p-6 shadow-sm">

    <div class="flex items-start gap-4">

        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-2xl">
            📄
        </div>

        <div class="flex-1">

            <p class="text-sm font-bold uppercase tracking-wide text-green-700">
                Dasar Penutupan Temuan
            </p>

            @if($laporan)

                <p class="mt-3 text-green-900 leading-relaxed">

                    Penutupan temuan ini didasarkan pada
                    <strong>Surat Nomor {{ $laporan->nomor_surat }}</strong>

                    @if($laporan->tanggal_surat)
                        tanggal
                        <strong>
                            {{ $laporan->tanggal_surat->locale('id')->translatedFormat('d F Y') }}
                        </strong>
                    @endif

                    @if($laporan->perihal)
                        tentang
                        <strong>{{ $laporan->perihal }}</strong>.
                    @endif

                </p>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">

                    <div>
                        <p class="text-sm font-semibold text-green-700">
                            Nomor Surat
                        </p>

                        <p class="mt-2 font-bold text-green-900">
                            {{ $laporan->nomor_surat }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-green-700">
                            Tanggal Surat
                        </p>

                        <p class="mt-2 font-bold text-green-900">
                            {{ $laporan->tanggal_surat?->locale('id')->translatedFormat('d F Y') }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex gap-3 flex-wrap">

                    <a href="{{ Storage::url($laporan->file_surat) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">

                        📄 Lihat Surat

                    </a>

                    <a href="{{ route('laporan.show',$laporan) }}"
                       class="rounded-xl border border-green-600 px-5 py-3 text-sm font-semibold text-green-700 hover:bg-green-100">

                        📋 Detail Laporan

                    </a>

                </div>

            @else

                <p class="mt-3 text-green-900">

                    Temuan telah ditutup namun belum terhubung ke laporan.

                </p>

            @endif

        </div>

    </div>

</div>

@endif


{{-- Riwayat Temuan --}}
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <div>
        <h2 class="text-lg font-bold text-gray-800">
            Riwayat Temuan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Perjalanan temuan sejak inspeksi sampai penyelesaian.
        </p>
    </div>

    <div class="mt-6 space-y-0">

        {{-- Temuan Dibuat --}}
        <div class="relative flex gap-4 pb-7">

            <div class="absolute left-4 top-8 h-full w-px bg-gray-200"></div>

            <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                1
            </div>

            <div class="flex-1">

                <p class="font-bold text-gray-800">
                    Temuan Dicatat
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $temuan->created_at
                        ? $temuan->created_at->translatedFormat('d F Y, H:i')
                        : '-' }}
                </p>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Temuan dicatat berdasarkan hasil inspeksi di
                    {{ $temuan->inspeksi?->bandara?->nama_bandara ?? 'bandar udara' }}.
                </p>

            </div>

        </div>

        {{-- Inspeksi --}}
        <div class="relative flex gap-4 pb-7">

            <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                2
            </div>

            <div class="flex-1">

                <p class="font-bold text-gray-800">
                    Inspeksi Bandar Udara
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $temuan->inspeksi?->tanggal
                        ? $temuan->inspeksi->tanggal->translatedFormat('d F Y')
                        : '-' }}
                </p>

                <a href="{{ route('inspeksi.show', $temuan->inspeksi_id) }}"
                   class="mt-2 inline-flex text-sm font-semibold text-blue-600 transition hover:text-blue-800">
                    Lihat detail inspeksi →
                </a>

            </div>

        </div>

        {{-- Penutupan --}}
        @if ($temuan->status === 'Close')

            @php
                $laporanRiwayat = $temuan->laporans
                    ->first(function ($laporan) {
                        return (bool) $laporan->pivot->menutup_temuan;
                    });
            @endphp

            <div class="relative flex gap-4">

                <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700">
                    ✓
                </div>

                <div class="flex-1">

                    <p class="font-bold text-gray-800">
                        Temuan Ditutup
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $temuan->tanggal_close
                            ? $temuan->tanggal_close->translatedFormat('d F Y')
                            : '-' }}
                    </p>

                    @if ($laporanRiwayat)

                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Ditutup berdasarkan surat
                            <span class="font-semibold text-gray-800">
                                {{ $laporanRiwayat->nomor_surat }}
                            </span>.
                        </p>

                        <a href="{{ route('laporan.show', $laporanRiwayat) }}"
                           class="mt-2 inline-flex text-sm font-semibold text-blue-600 transition hover:text-blue-800">
                            Lihat laporan tindak lanjut →
                        </a>

                    @else

                        <p class="mt-2 text-sm text-gray-600">
                            Temuan ditutup melalui perubahan status secara manual.
                        </p>

                    @endif

                </div>

            </div>

        @endif

    </div>

</div>

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

                    <div class="flex flex-col gap-2 sm:flex-row">

                        <a href="{{ route('tindaklanjut.create', ['temuan_id' => $temuan->id]) }}"
                           class="rounded-xl bg-blue-600 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                            + Tambah Tindak Lanjut
                        </a>


                        @if ($temuan->status !== 'Close')

                            <button
                                type="button"
                                onclick="document.getElementById('form-penutupan').classList.toggle('hidden')"
                                class="rounded-xl bg-red-600 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                Tutup Temuan
                            </button>

                        @endif

                    </div>

                </div>

                <div
                    id="form-penutupan"
                    class="mt-6 hidden rounded-2xl border border-red-200 bg-red-50 p-5"
                >

                    <div class="mb-4">

                        <h3 class="text-lg font-bold text-red-800">
                            ⚠️ Penutupan Temuan
                        </h3>

                        <p class="mt-1 text-sm text-red-700">
                            Pastikan tindak lanjut telah selesai dan dokumen pendukung tersedia sebelum menutup temuan.
                        </p>

                    </div>


                    <form
                        action="{{ route('temuan.close', $temuan) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="mb-4">

                            <label
                                class="mb-2 block text-sm font-semibold text-red-900"
                            >
                                Keterangan Penutupan
                            </label>


                            <textarea
                                name="keterangan_penutupan"
                                rows="4"
                                class="w-full rounded-xl border-red-300 bg-white shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="Jelaskan dasar penutupan temuan..."
                                required
                            ></textarea>

                        </div>



                        <div class="mb-5">

                            <label
                                class="mb-2 block text-sm font-semibold text-red-900"
                            >
                                Dokumen Pendukung (PDF)
                            </label>


                            <input
                                type="file"
                                name="dokumen_penutupan"
                                accept=".pdf"
                                class="w-full rounded-xl border-red-300 bg-white shadow-sm"
                                required
                            >


                            <p class="mt-1 text-xs text-red-700">
                                Format PDF maksimal 5 MB.
                            </p>

                        </div>



                        <button
                            type="submit"
                            onclick="return confirm('Yakin ingin menutup temuan ini?')"
                            class="rounded-xl bg-red-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-800"
                        >
                            Konfirmasi Tutup Temuan
                        </button>


                    </form>


                    @if ($temuan->tanggal_close)

                        <div class="mt-5 rounded-xl border border-green-200 bg-green-50 p-4">

                            <p class="text-sm font-semibold text-green-800">
                                Tanggal Penutupan
                            </p>

                            <p class="mt-1 text-sm text-green-700">
                                {{ $temuan->tanggal_close->format('d F Y') }}
                            </p>

                            <a
                                href="{{ route('laporan.index') }}"
                                class="mt-3 inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-green-700"
                            >
                                Lihat Arsip Tindak Lanjut
                            </a>

                        </div>

                    @endif


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
                                        href="{{ route('tindaklanjut.edit', ['tindakLanjut' => $item->id]) }}"
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
                            Dokumentasi foto tindak lanjut.
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
