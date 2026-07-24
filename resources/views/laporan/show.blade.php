@extends('layouts.app')

@section('content')

<style>
    @media print {
        body {
            background: white !important;
        }

        .print-hidden {
            display: none !important;
        }

        .print-container {
            box-shadow: none !important;
            border: none !important;
        }

        .print-break-inside {
            break-inside: avoid;
        }
    }
</style>

<div class="space-y-6">

    {{-- Action --}}
    <div class="print-hidden flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <a href="{{ route('laporan.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
            ← Kembali
        </a>

        <button type="button"
                onclick="window.print()"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
            Cetak Laporan
        </button>

    </div>


    <div class="print-container overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Report Header --}}
        <div class="border-b border-gray-200 px-6 py-8 text-center sm:px-10">

            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">
                Sistem Informasi Temuan Bandar Udara
            </p>

            <h1 class="mt-3 text-2xl font-bold uppercase text-gray-900 sm:text-3xl">
                Laporan Hasil Inspeksi
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Rekapitulasi hasil inspeksi dan tindak lanjut temuan
            </p>

        </div>


        {{-- Inspection Information --}}
        <div class="grid gap-6 border-b border-gray-200 px-6 py-7 sm:px-10 lg:grid-cols-2">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Bandar Udara
                </p>

                <p class="mt-2 text-lg font-bold text-gray-900">
                    {{ $inspeksi->bandara->nama_bandara ?? 'Bandara tidak tersedia' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Tanggal Inspeksi
                </p>

                <p class="mt-2 text-lg font-bold text-gray-900">
                    {{ $inspeksi->tanggal
                        ? \Carbon\Carbon::parse($inspeksi->tanggal)->translatedFormat('d F Y')
                        : '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Petugas Inspeksi
                </p>

                <div class="mt-2 flex flex-wrap gap-2">
                    @forelse ($inspeksi->petugas as $petugas)
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700">
                            {{ $petugas->nama_petugas }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-500">
                            Belum ada petugas.
                        </span>
                    @endforelse
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Keterangan Inspeksi
                </p>

                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">
                    {{ $inspeksi->keterangan ?: '-' }}
                </p>
            </div>

        </div>


        {{-- Summary --}}
        @php
            $jumlahTemuan = $inspeksi->temuans->count();
            $jumlahOpen = $inspeksi->temuans
                ->where('status', 'Open')
                ->count();
            $jumlahClose = $inspeksi->temuans
                ->where('status', 'Close')
                ->count();
            $jumlahRisikoTinggi = $inspeksi->temuans
                ->where('tingkat_risiko', 'Tinggi')
                ->count();
        @endphp

        <div class="grid gap-4 border-b border-gray-200 bg-gray-50 px-6 py-6 sm:grid-cols-2 sm:px-10 lg:grid-cols-4">

            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Total Temuan
                </p>

                <p class="mt-2 text-2xl font-bold text-gray-900">
                    {{ $jumlahTemuan }}
                </p>
            </div>

            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-red-600">
                    Open
                </p>

                <p class="mt-2 text-2xl font-bold text-red-700">
                    {{ $jumlahOpen }}
                </p>
            </div>

            <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-green-600">
                    Close
                </p>

                <p class="mt-2 text-2xl font-bold text-green-700">
                    {{ $jumlahClose }}
                </p>
            </div>

            <div class="rounded-xl border border-orange-200 bg-orange-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">
                    Risiko Tinggi
                </p>

                <p class="mt-2 text-2xl font-bold text-orange-700">
                    {{ $jumlahRisikoTinggi }}
                </p>
            </div>

        </div>


        {{-- Findings --}}
        <div class="px-6 py-8 sm:px-10">

            <div class="mb-6">
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Hasil Inspeksi
                </p>

                <h2 class="mt-2 text-xl font-bold text-gray-900">
                    Daftar Temuan
                </h2>
            </div>

            <div class="space-y-6">

                @forelse ($inspeksi->temuans as $index => $temuan)

                    @php
                        $statusClass = $temuan->status === 'Close'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-red-50 text-red-700 border-red-200';

                        $risikoClass = $temuan->tingkat_risiko === 'Tinggi'
                            ? 'bg-red-50 text-red-700 border-red-200'
                            : 'bg-green-50 text-green-700 border-green-200';
                    @endphp

                    <article class="print-break-inside overflow-hidden rounded-2xl border border-gray-200">

                        <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Temuan {{ $index + 1 }}
                                </p>

                                <h3 class="mt-1 text-lg font-bold text-gray-900">
                                    {{ $temuan->nomor_temuan ?: 'Nomor temuan belum tersedia' }}
                                </h3>
                            </div>

                            <div class="flex flex-wrap gap-2">

                                <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $risikoClass }}">
                                    Risiko {{ $temuan->tingkat_risiko }}
                                </span>

                                <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                    {{ $temuan->status }}
                                </span>

                            </div>

                        </div>

                        <div class="grid gap-6 px-5 py-6 lg:grid-cols-2">

                            <div class="lg:col-span-2">
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

                                <p class="mt-2 text-sm font-medium text-gray-800">
                                    {{ $temuan->unsur_elemen ?: '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Lokasi
                                </p>

                                <p class="mt-2 text-sm font-medium text-gray-800">
                                    {{ $temuan->lokasi ?: '-' }}
                                </p>
                            </div>

                            @if ($temuan->status === 'Close')
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Tanggal Penutupan
                                    </p>

                                    <p class="mt-2 text-sm font-medium text-gray-800">
                                        {{ $temuan->tanggal_close
                                            ? \Carbon\Carbon::parse($temuan->tanggal_close)->translatedFormat('d F Y')
                                            : '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        Keterangan Penutupan
                                    </p>

                                    <p class="mt-2 whitespace-pre-line text-sm text-gray-800">
                                        {{ $temuan->keterangan_penutupan ?: '-' }}
                                    </p>
                                </div>
                            @endif

                        </div>


                        {{-- Follow Up --}}
                        <div class="border-t border-gray-200 bg-gray-50 px-5 py-6">

                            <h4 class="text-sm font-bold uppercase tracking-wider text-gray-700">
                                Tindak Lanjut
                            </h4>

                            <div class="mt-4 space-y-4">

                                @forelse ($temuan->tindakLanjut as $tl)

                                    @php
                                        $tlStatusClass = match ($tl->status) {
                                            'Selesai' => 'bg-green-50 text-green-700 border-green-200',
                                            'Dalam Tindak Lanjut' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            default => 'bg-red-50 text-red-700 border-red-200',
                                        };
                                    @endphp

                                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                            <p class="text-sm font-bold text-gray-900">
                                                {{ $tl->rencana_perbaikan ?: 'Rencana perbaikan belum tersedia' }}
                                            </p>

                                            <span class="w-fit rounded-full border px-3 py-1 text-xs font-bold {{ $tlStatusClass }}">
                                                {{ $tl->status }}
                                            </span>

                                        </div>

                                        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                    PIC
                                                </p>

                                                <p class="mt-1 text-sm text-gray-800">
                                                    {{ $tl->pic ?: '-' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                    Deadline
                                                </p>

                                                <p class="mt-1 text-sm text-gray-800">
                                                    {{ $tl->deadline
                                                        ? \Carbon\Carbon::parse($tl->deadline)->translatedFormat('d F Y')
                                                        : '-' }}
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                    Catatan
                                                </p>

                                                <p class="mt-1 whitespace-pre-line text-sm text-gray-800">
                                                    {{ $tl->catatan ?: '-' }}
                                                </p>
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="rounded-xl border border-dashed border-gray-300 bg-white px-5 py-7 text-center">
                                        <p class="text-sm font-medium text-gray-500">
                                            Belum terdapat data tindak lanjut.
                                        </p>
                                    </div>

                                @endforelse

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="rounded-2xl border border-dashed border-gray-300 px-6 py-12 text-center">
                        <p class="text-base font-semibold text-gray-700">
                            Tidak terdapat temuan
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Inspeksi ini belum memiliki data temuan.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection
