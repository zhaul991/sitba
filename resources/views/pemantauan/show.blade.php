@extends('layouts.app')

@section('content')

@php
    $totalTemuan = $inspeksi->temuans->count();
    $totalOpen = $inspeksi->temuans->where('status', 'Open')->count();
    $totalClose = $inspeksi->temuans->where('status', 'Close')->count();

    $totalHigh = $inspeksi->temuans
        ->filter(function ($temuan) {
            $risiko = strtolower(trim($temuan->tingkat_risiko ?? ''));

            return in_array($risiko, ['high', 'tinggi']);
        })
        ->count();

    $totalLow = $inspeksi->temuans
        ->filter(function ($temuan) {
            $risiko = strtolower(trim($temuan->tingkat_risiko ?? ''));

            return in_array($risiko, ['low', 'rendah']);
        })
        ->count();

    $persentaseSelesai = $totalTemuan > 0
        ? round(($totalClose / $totalTemuan) * 100)
        : 0;

    $persentaseHigh = $totalTemuan > 0
        ? round(($totalHigh / $totalTemuan) * 100)
        : 0;

    $persentaseLow = $totalTemuan > 0
        ? round(($totalLow / $totalTemuan) * 100)
        : 0;
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Modul Inspeksi
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900 md:text-3xl">
                    Detail Kegiatan Pemantauan
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Informasi kegiatan, tim inspektur, dan daftar temuan bandar udara.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a
                    href="{{ route('pemantauan.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    ← Kembali
                </a>

                <a
                    href="{{ route('pemantauan.edit', $inspeksi) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600"
                >
                    Edit Pemantauan
                </a>
            </div>

        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-500">
                Total Temuan
            </p>

            <p class="mt-3 text-3xl font-bold text-gray-900">
                {{ $totalTemuan }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Seluruh temuan inspeksi
            </p>
        </div>

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
            <p class="text-sm font-semibold text-amber-700">
                Temuan Open
            </p>

            <p class="mt-3 text-3xl font-bold text-amber-900">
                {{ $totalOpen }}
            </p>

            <p class="mt-2 text-xs text-amber-700">
                Masih perlu ditindaklanjuti
            </p>
        </div>

        <div class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-semibold text-green-700">
                Temuan Close
            </p>

            <p class="mt-3 text-3xl font-bold text-green-900">
                {{ $totalClose }}
            </p>

            <p class="mt-2 text-xs text-green-700">
                Telah diselesaikan
            </p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
            <p class="text-sm font-semibold text-red-700">
                Risiko Tinggi
            </p>

            <p class="mt-3 text-3xl font-bold text-red-900">
                {{ $totalHigh }}
            </p>

            <p class="mt-2 text-xs text-red-700">
                Perlu prioritas utama
            </p>
        </div>

        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
            <p class="text-sm font-semibold text-blue-700">
                Penyelesaian
            </p>

            <p class="mt-3 text-3xl font-bold text-blue-900">
                {{ $persentaseSelesai }}%
            </p>

            <div class="mt-3 h-2 overflow-hidden rounded-full bg-blue-100">
                <div
                    class="h-full rounded-full bg-blue-600"
                    style="width: {{ min($persentaseSelesai, 100) }}%"
                ></div>
            </div>
        </div>

    </div>

    <div class="grid gap-6 xl:grid-cols-3">

        {{-- Kolom Utama --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- Informasi Inspeksi --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">
                    <h2 class="text-lg font-bold text-gray-900">
                        Informasi Inspeksi
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Informasi kegiatan pemantauan dan jenis pelaksanaan.
                    </p>
                </div>

                <div class="grid gap-6 p-6 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Bandar Udara
                        </p>

                        <p class="mt-2 text-lg font-bold text-gray-900">
                            {{ $inspeksi->bandara->nama_bandara }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Kode: {{ $inspeksi->bandara->kode_bandara ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Tanggal Inspeksi
                        </p>

                        <p class="mt-2 text-lg font-bold text-gray-900">
                            {{ $inspeksi->tanggal->translatedFormat('d F Y') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $inspeksi->tanggal->format('d-m-Y') }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <div class="border-t border-gray-100 pt-6">

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Keterangan
                            </p>

                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-700">
                                {{ $inspeksi->jenis_inspeksi ?: '-' }}
                            </p>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Daftar Temuan --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Daftar Temuan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Temuan yang tercatat dalam kegiatan pemantauan ini.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">
                            {{ $totalTemuan }} Temuan
                        </span>

                        <a
                            href="{{ route('temuan.create', ['inspeksi_id' => $inspeksi->id]) }}"
                            class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            + Tambah Temuan
                        </a>
                    </div>

                </div>

                @if ($inspeksi->temuans->isNotEmpty())

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        No.
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Nomor Temuan
                                    </th>

                                    <th class="min-w-[260px] px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Uraian Temuan
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Risiko
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Lokasi
                                    </th>

                                    <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach ($inspeksi->temuans as $temuan)

                                    @php
                                        $risiko = strtolower($temuan->tingkat_risiko ?? '');

                                        $kelasRisiko = match (true) {
                                            in_array($risiko, ['high', 'tinggi']) =>
                                                'border-red-200 bg-red-50 text-red-700',

                                            in_array($risiko, ['low', 'rendah']) =>
                                                'border-green-200 bg-green-50 text-green-700',

                                            default =>
                                                'border-gray-200 bg-gray-50 text-gray-700',
                                        };

                                        $kelasStatus = $temuan->status === 'Close'
                                            ? 'border-green-200 bg-green-50 text-green-700'
                                            : 'border-amber-200 bg-amber-50 text-amber-700';
                                    @endphp

                                    <tr class="align-top transition hover:bg-gray-50">

                                        <td class="whitespace-nowrap px-5 py-5 text-sm font-medium text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-5">
                                            <p class="text-sm font-bold text-gray-900">
                                                {{ $temuan->nomor_temuan ?: 'Temuan #' . $temuan->id }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $temuan->unsur_elemen ?: '-' }}
                                            </p>
                                        </td>

                                        <td class="px-5 py-5">
                                            <p class="whitespace-pre-line text-sm leading-6 text-gray-700">
                                                {{ $temuan->uraian_temuan ?: 'Tidak ada uraian temuan.' }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-5">
                                            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $kelasRisiko }}">
                                                {{ $temuan->tingkat_risiko ?: '-' }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-5 text-sm text-gray-700">
                                            {{ $temuan->lokasi ?: '-' }}
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-5">
                                            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $kelasStatus }}">
                                                {{ $temuan->status ?: 'Open' }}
                                            </span>

                                            @if ($temuan->status === 'Close' && $temuan->tanggal_close)
                                                <p class="mt-2 text-xs text-gray-500">
                                                    {{ $temuan->tanggal_close->format('d-m-Y') }}
                                                </p>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-5 py-5 text-right">
                                            <div class="flex items-center justify-end gap-2">

                                                <a
                                                    href="{{ route('temuan.show', $temuan) }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                                >
                                                    Lihat
                                                </a>

                                                <a
                                                    href="{{ route('temuan.edit', $temuan) }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100"
                                                >
                                                    Edit
                                                </a>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>

                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <p class="text-sm text-gray-500">
                            Menampilkan {{ $totalTemuan }} temuan dari kegiatan pemantauan ini.
                        </p>
                    </div>

                @else

                    <div class="px-6 py-12 text-center">

                        <div class="text-4xl">
                            📋
                        </div>

                        <p class="mt-4 font-semibold text-gray-700">
                            Belum ada temuan
                        </p>

                        <p class="mt-2 text-sm text-gray-500">
                            Temuan hasil inspeksi akan tampil pada bagian ini.
                        </p>

                        <a
                            href="{{ route('temuan.create', ['inspeksi_id' => $inspeksi->id]) }}"
                            class="mt-5 inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                        >
                            Tambah Temuan Pertama
                        </a>

                    </div>

                @endif

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Tim Inspektur --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">
                    <h2 class="text-lg font-bold text-gray-900">
                        Tim Inspektur
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Personel yang melaksanakan inspeksi.
                    </p>
                </div>

                <div class="space-y-3 p-6">

                    @forelse ($inspeksi->petugas as $inspektur)

                        <div class="rounded-xl border border-gray-200 p-4">
                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                                    {{ strtoupper(substr($inspektur->nama_petugas, 0, 1)) }}
                                </div>

                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900">
                                        {{ $inspektur->nama_petugas }}
                                    </p>

                                    <p class="mt-1 break-all text-sm text-gray-500">
                                        NIP: {{ $inspektur->nip ?: '-' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-gray-300 px-4 py-8 text-center">
                            <p class="text-sm text-gray-500">
                                Belum ada inspektur yang dipilih.
                            </p>
                        </div>

                    @endforelse

                </div>
            </div>

            {{-- Distribusi Risiko --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-gray-900">
                    Distribusi Risiko
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Ringkasan tingkat risiko High dan Low.
                </p>

                <div class="mt-6 space-y-6">

                    {{-- High --}}
                    <div>
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-bold text-red-700">
                                    High Risk
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Perlu prioritas utama
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xl font-bold text-red-700">
                                    {{ $totalHigh }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $persentaseHigh }}%
                                </p>
                            </div>

                        </div>

                        <div class="mt-3 h-3 overflow-hidden rounded-full bg-red-100">
                            <div
                                class="h-full rounded-full bg-red-500"
                                style="width: {{ min($persentaseHigh, 100) }}%"
                            ></div>
                        </div>
                    </div>

                    {{-- Low --}}
                    <div>
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-bold text-green-700">
                                    Low Risk
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Risiko rendah
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xl font-bold text-green-700">
                                    {{ $totalLow }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $persentaseLow }}%
                                </p>
                            </div>

                        </div>

                        <div class="mt-3 h-3 overflow-hidden rounded-full bg-green-100">
                            <div
                                class="h-full rounded-full bg-green-500"
                                style="width: {{ min($persentaseLow, 100) }}%"
                            ></div>
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">

                    <span class="text-sm font-semibold text-gray-600">
                        Total Temuan
                    </span>

                    <span class="text-lg font-bold text-gray-900">
                        {{ $totalTemuan }}
                    </span>

                </div>

            </div>

            {{-- Metadata --}}
            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6">

                <p class="text-sm font-semibold text-blue-700">
                    ID Inspeksi
                </p>

                <p class="mt-2 text-3xl font-bold text-blue-900">
                    #{{ $inspeksi->id }}
                </p>

                <div class="mt-5 space-y-2 border-t border-blue-200 pt-4 text-sm text-blue-800">

                    <p>
                        Dibuat:
                        {{ $inspeksi->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                    </p>

                    <p>
                        Diperbarui:
                        {{ $inspeksi->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
