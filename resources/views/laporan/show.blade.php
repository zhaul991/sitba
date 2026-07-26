@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Action --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('laporan.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
            ← Kembali
        </a>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('laporan.edit', $laporan) }}"
               class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-amber-50 px-5 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
                Edit Laporan
            </a>

            @if ($laporan->file_surat)
                <a href="{{ asset('storage/' . $laporan->file_surat) }}"
                   target="_blank"
                   class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Lihat Dokumen
                </a>
            @endif
        </div>
    </div>

    {{-- Informasi Laporan --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-6 py-7">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                Laporan Tindak Lanjut
            </p>

            <h1 class="mt-2 text-2xl font-bold text-gray-900">
                {{ $laporan->nomor_surat }}
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Surat tindak lanjut yang disampaikan oleh bandar udara.
            </p>
        </div>

        <div class="grid gap-6 px-6 py-7 md:grid-cols-2">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Bandar Udara
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ $laporan->bandara->nama_bandara ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Tanggal Surat
                </p>

                <p class="mt-2 text-base font-semibold text-gray-900">
                    {{ $laporan->tanggal_surat
                        ? $laporan->tanggal_surat->translatedFormat('d F Y')
                        : '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Perihal
                </p>

                <p class="mt-2 text-sm text-gray-800">
                    {{ $laporan->perihal ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Dokumen
                </p>

                <div class="mt-2">
                    @if ($laporan->file_surat)
                        <a href="{{ asset('storage/' . $laporan->file_surat) }}"
                           target="_blank"
                           class="inline-flex rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-100">
                            Buka PDF
                        </a>
                    @else
                        <span class="text-sm text-gray-500">
                            Tidak ada dokumen.
                        </span>
                    @endif
                </div>
            </div>

            <div class="md:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Keterangan
                </p>

                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-800">
                    {{ $laporan->keterangan ?: '-' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Temuan Terkait --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                Temuan yang Ditindaklanjuti
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Daftar temuan yang ditutup berdasarkan laporan tindak lanjut ini.
            </p>
        </div>

        <span class="inline-flex w-fit items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
            {{ $laporan->temuans->count() }} Temuan
        </span>
    </div>

    <div class="space-y-4 p-6">

        @forelse ($laporan->temuans as $temuan)

            @php
                $statusClass = $temuan->status === 'Close'
                    ? 'border-green-200 bg-green-50 text-green-700'
                    : 'border-amber-200 bg-amber-50 text-amber-700';
            @endphp

            <div class="rounded-2xl border border-gray-200 p-5 transition hover:border-blue-200 hover:shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Nomor Temuan
                        </p>

                        <h3 class="mt-1 text-lg font-bold text-gray-900">
                            {{ $temuan->nomor_temuan ?: '-' }}
                        </h3>
                    </div>

                    <span class="inline-flex w-fit rounded-full border px-3 py-1 text-xs font-bold {{ $statusClass }}">
                        {{ $temuan->status }}
                    </span>

                </div>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Uraian Temuan
                        </p>

                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-800">
                            {{ $temuan->uraian_temuan ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Unsur / Elemen
                        </p>

                        <p class="mt-2 text-sm text-gray-800">
                            {{ $temuan->unsur_elemen ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Lokasi
                        </p>

                        <p class="mt-2 text-sm text-gray-800">
                            {{ $temuan->lokasi ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Tanggal Ditutup
                        </p>

                        <p class="mt-2 text-sm font-semibold text-gray-800">
                            {{ $temuan->tanggal_close
                                ? \Carbon\Carbon::parse($temuan->tanggal_close)->translatedFormat('d F Y')
                                : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Dasar Penutupan
                        </p>

                        <p class="mt-2 whitespace-pre-line text-sm text-gray-800">
                            {{ $temuan->keterangan_penutupan ?: 'Ditutup berdasarkan laporan ini.' }}
                        </p>
                    </div>

                </div>

                <div class="mt-5 border-t border-gray-100 pt-4">
                    <a href="{{ route('temuan.show', $temuan) }}"
                       class="inline-flex items-center text-sm font-semibold text-blue-600 transition hover:text-blue-800">
                        Lihat Detail Temuan →
                    </a>
                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-dashed border-gray-300 px-6 py-12 text-center">
                <p class="font-semibold text-gray-700">
                    Belum ada temuan yang dikaitkan
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Laporan ini belum memiliki data temuan.
                </p>
            </div>

        @endforelse

    </div>
</div>

@endsection