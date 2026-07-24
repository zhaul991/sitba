@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-6 md:p-8">

    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Sistem Informasi Temuan Bandar Udara
                </p>

                <h1 class="mt-2 text-3xl font-bold text-gray-900">
                    Monitoring Center
                </h1>

                <p class="mt-2 text-gray-500">
                    Selamat datang, {{ auth()->user()->name ?? 'Pengguna' }}.
                    Pantau pelaksanaan inspeksi dan penyelesaian temuan bandar udara.
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Hari ini
                </p>

                <p class="mt-1 font-bold text-gray-800">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>

                <p
                    id="jam-dashboard"
                    class="mt-1 text-sm font-semibold text-blue-600"
                >
                    {{ now()->format('H:i:s') }}
                </p>
            </div>

        </div>

        {{-- Ringkasan utama --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">

            <a
                href="{{ route('bandara.index') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
            >
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        ✈️
                    </div>

                    <span class="text-xs font-semibold uppercase text-gray-400">
                        Bandara
                    </span>
                </div>

                <p class="mt-5 text-3xl font-bold text-gray-900">
                    {{ number_format($jumlahBandara) }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Total bandar udara
                </p>
            </a>

            <a
                href="{{ route('inspeksi.index') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
            >
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-xl">
                        📋
                    </div>

                    <span class="text-xs font-semibold uppercase text-gray-400">
                        Inspeksi
                    </span>
                </div>

                <p class="mt-5 text-3xl font-bold text-gray-900">
                    {{ number_format($jumlahInspeksi) }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Total kegiatan inspeksi
                </p>
            </a>

            <a
                href="{{ route('temuan.index') }}"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
            >
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">
                        🔎
                    </div>

                    <span class="text-xs font-semibold uppercase text-gray-400">
                        Temuan
                    </span>
                </div>

                <p class="mt-5 text-3xl font-bold text-gray-900">
                    {{ number_format($jumlahTemuan) }}
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Seluruh temuan
                </p>
            </a>

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-xl">
                        ⚠️
                    </div>

                    <span class="text-xs font-semibold uppercase text-red-500">
                        Open
                    </span>
                </div>

                <p class="mt-5 text-3xl font-bold text-red-700">
                    {{ number_format($temuanOpen) }}
                </p>

                <p class="mt-1 text-sm text-red-600">
                    Temuan belum ditutup
                </p>
            </div>

            <div class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-xl">
                        ✓
                    </div>

                    <span class="text-xs font-semibold uppercase text-green-600">
                        Close
                    </span>
                </div>

                <p class="mt-5 text-3xl font-bold text-green-700">
                    {{ number_format($temuanClose) }}
                </p>

                <p class="mt-1 text-sm text-green-600">
                    Temuan telah ditutup
                </p>
            </div>

        </div>

        {{-- Monitoring tindak lanjut --}}
        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Monitoring Tindak Lanjut
                    </p>

                    <h2 class="mt-2 text-xl font-bold text-gray-900">
                        Status penyelesaian tindak lanjut
                    </h2>

                </div>

                <div class="rounded-xl border border-green-100 bg-green-50 px-5 py-3 text-center">

                    <p class="text-3xl font-bold text-green-700">
                        {{ $persentaseTindakLanjutClose }}%
                    </p>

                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-green-600">
                        Telah Close
                    </p>

                </div>

            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-2">

                <div class="rounded-xl border border-red-200 bg-red-50 p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wider text-red-600">
                                Open
                            </p>

                            <p class="mt-2 text-4xl font-bold text-red-700">
                                {{ number_format($tindakLanjutOpen) }}
                            </p>
                        </div>

                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white text-2xl shadow-sm">
                            ⚠️
                        </div>

                    </div>

                    <p class="mt-4 text-sm text-red-600">
                        Tindak lanjut belum selesai atau masih dalam proses.
                    </p>

                </div>

                <div class="rounded-xl border border-green-200 bg-green-50 p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wider text-green-600">
                                Close
                            </p>

                            <p class="mt-2 text-4xl font-bold text-green-700">
                                {{ number_format($tindakLanjutClose) }}
                            </p>
                        </div>

                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white text-2xl shadow-sm">
                            ✓
                        </div>

                    </div>

                    <p class="mt-4 text-sm text-green-600">
                        Tindak lanjut telah selesai atau temuan induknya sudah ditutup.
                    </p>

                </div>

            </div>

            <div class="mt-6">

                <div class="mb-2 flex items-center justify-between">

                    <p class="text-sm font-semibold text-gray-700">
                        Progres Penyelesaian Tindak Lanjut
                    </p>

                    <p class="text-sm font-bold text-green-600">
                        {{ number_format($tindakLanjutClose) }}
                        dari
                        {{ number_format($jumlahTindakLanjutAktif) }}
                    </p>

                </div>

                <div class="h-4 overflow-hidden rounded-full bg-gray-100">

                    <div
                        class="h-full rounded-full bg-green-500 transition-all duration-500"
                        style="width: {{ min($persentaseTindakLanjutClose, 100) }}%"
                    ></div>

                </div>

            </div>

        </div>

        {{-- Distribusi status dan risiko --}}
        <div class="mt-6 grid gap-6 xl:grid-cols-2">

            {{-- Distribusi status --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                        Distribusi Status
                    </p>

                    <h2 class="mt-2 text-lg font-bold text-gray-900">
                        Kondisi penyelesaian seluruh temuan
                    </h2>
                </div>

                <div class="mt-6 space-y-6">

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-red-500"></span>

                                <p class="text-sm font-semibold text-gray-700">
                                    Open
                                </p>
                            </div>

                            <p class="text-sm font-bold text-red-600">
                                {{ number_format($temuanOpen) }}
                                <span class="font-medium text-gray-400">
                                    ({{ $persentaseOpen }}%)
                                </span>
                            </p>
                        </div>

                        <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-red-500 transition-all duration-500"
                                style="width: {{ min($persentaseOpen, 100) }}%"
                            ></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-green-500"></span>

                                <p class="text-sm font-semibold text-gray-700">
                                    Close
                                </p>
                            </div>

                            <p class="text-sm font-bold text-green-600">
                                {{ number_format($temuanClose) }}
                                <span class="font-medium text-gray-400">
                                    ({{ $persentaseClose }}%)
                                </span>
                            </p>
                        </div>

                        <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-green-500 transition-all duration-500"
                                style="width: {{ min($persentaseClose, 100) }}%"
                            ></div>
                        </div>
                    </div>

                </div>

                <div class="mt-6 rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Sebanyak
                        <span class="font-bold text-gray-800">
                            {{ $persentaseSelesai }}%
                        </span>
                        dari seluruh temuan telah diselesaikan dan ditutup.
                    </p>
                </div>

            </div>

            {{-- Distribusi risiko --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                        Distribusi Risiko
                    </p>

                    <h2 class="mt-2 text-lg font-bold text-gray-900">
                        Tingkat risiko seluruh temuan
                    </h2>
                </div>

                <div class="mt-6 space-y-6">

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-green-500"></span>

                                <p class="text-sm font-semibold text-gray-700">
                                    Risiko Rendah
                                </p>
                            </div>

                            <p class="text-sm font-bold text-green-600">
                                {{ number_format($risikoRendah) }}
                                <span class="font-medium text-gray-400">
                                    ({{ $persentaseRisikoRendah }}%)
                                </span>
                            </p>
                        </div>

                        <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-green-500 transition-all duration-500"
                                style="width: {{ min($persentaseRisikoRendah, 100) }}%"
                            ></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-red-500"></span>

                                <p class="text-sm font-semibold text-gray-700">
                                    Risiko Tinggi
                                </p>
                            </div>

                            <p class="text-sm font-bold text-red-600">
                                {{ number_format($risikoTinggi) }}
                                <span class="font-medium text-gray-400">
                                    ({{ $persentaseRisikoTinggi }}%)
                                </span>
                            </p>
                        </div>

                        <div class="h-3 overflow-hidden rounded-full bg-gray-100">
                            <div
                                class="h-full rounded-full bg-red-500 transition-all duration-500"
                                style="width: {{ min($persentaseRisikoTinggi, 100) }}%"
                            ></div>
                        </div>
                    </div>

                </div>

                <div class="mt-6 rounded-xl border border-red-100 bg-red-50 p-4">
                    <p class="text-sm text-red-700">
                        Terdapat
                        <span class="font-bold">
                            {{ number_format($risikoTinggi) }}
                        </span>
                        temuan risiko tinggi yang memerlukan perhatian.
                    </p>
                </div>

            </div>

        </div>

        {{-- Risiko dan overdue --}}
        <div class="mt-6 grid gap-5 md:grid-cols-3">

            <div class="rounded-2xl border border-green-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Risiko Rendah
                        </p>

                        <p class="mt-2 text-3xl font-bold text-green-700">
                            {{ number_format($risikoRendah) }}
                        </p>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-2xl">
                        🟢
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    Temuan dengan tingkat risiko rendah.
                </p>
            </div>

            <div class="rounded-2xl border border-red-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Risiko Tinggi
                        </p>

                        <p class="mt-2 text-3xl font-bold text-red-700">
                            {{ number_format($risikoTinggi) }}
                        </p>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-2xl">
                        🔴
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    Temuan yang membutuhkan perhatian prioritas.
                </p>
            </div>

            <div class="rounded-2xl border border-amber-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Lewat Deadline
                        </p>

                        <p class="mt-2 text-3xl font-bold text-amber-700">
                            {{ number_format($tindakLanjutOverdue) }}
                        </p>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-2xl">
                        ⏰
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    Tindak lanjut belum selesai dan melewati batas waktu.
                </p>
            </div>

        </div>

        {{-- Tindak lanjut mendesak --}}
        <div class="mt-6 overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-sm">

            <div class="flex flex-col gap-4 border-b border-amber-100 bg-amber-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-xl">
                        ⏰
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-amber-900">
                            Tindak Lanjut Mendesak
                        </h2>

                        <p class="mt-1 text-sm text-amber-700">
                            Tindak lanjut yang telah melewati atau mendekati deadline.
                        </p>
                    </div>

                </div>

                <div class="rounded-xl border border-amber-200 bg-white px-4 py-2 text-center">

                    <p class="text-2xl font-bold text-amber-700">
                        {{ number_format($tindakLanjutOverdue) }}
                    </p>

                    <p class="text-xs font-semibold uppercase text-amber-500">
                        Lewat Deadline
                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Temuan
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Bandar Udara
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                PIC
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Deadline
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Kondisi
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($tindakLanjutMendesak as $tindakLanjut)
                            @php
                                $hari = now()
                                    ->startOfDay()
                                    ->diffInDays(
                                        $tindakLanjut->deadline->copy()->startOfDay(),
                                        false
                                    );

                                $terlambat = $hari < 0;

                                $kondisiClass = $terlambat
                                    ? 'border-red-200 bg-red-50 text-red-700'
                                    : ($hari <= 7
                                        ? 'border-amber-200 bg-amber-50 text-amber-700'
                                        : 'border-blue-200 bg-blue-50 text-blue-700');

                                $teksKondisi = match (true) {
                                    $hari < 0 =>
                                        abs($hari) . ' hari terlambat',

                                    $hari === 0 =>
                                        'Deadline hari ini',

                                    $hari === 1 =>
                                        '1 hari lagi',

                                    default =>
                                        $hari . ' hari lagi',
                                };
                            @endphp

                            <tr class="transition hover:bg-amber-50/40">

                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">
                                        {{ $tindakLanjut->temuan?->nomor_temuan ?? '-' }}
                                    </p>

                                    <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                        {{ $tindakLanjut->rencana_perbaikan }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-700">
                                        {{
                                            $tindakLanjut
                                                ->temuan
                                                ?->inspeksi
                                                ?->bandara
                                                ?->nama_bandara
                                            ?? 'Bandara tidak tersedia'
                                        }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $tindakLanjut->pic ?: '-' }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-700">
                                        {{ $tindakLanjut->deadline->format('d-m-Y') }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-lg border px-3 py-1 text-xs font-bold {{ $kondisiClass }}">
                                        {{ $teksKondisi }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    @if ($tindakLanjut->temuan)
                                        <a
                                            href="{{ route('temuan.show', $tindakLanjut->temuan) }}"
                                            class="inline-flex rounded-lg bg-amber-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-amber-700"
                                        >
                                            Lihat Detail
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">
                                            Tidak tersedia
                                        </span>
                                    @endif

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-xl">
                                        ✓
                                    </div>

                                    <p class="mt-4 font-semibold text-gray-700">
                                        Tidak ada tindak lanjut mendesak
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Seluruh tindak lanjut telah selesai atau belum memiliki deadline.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Temuan prioritas --}}
        <div class="mt-6 overflow-hidden rounded-2xl border border-red-200 bg-white shadow-sm">

            <div class="flex flex-col gap-4 border-b border-red-100 bg-red-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-xl">
                            🚨
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-red-900">
                                Temuan Prioritas
                            </h2>

                            <p class="mt-1 text-sm text-red-700">
                                Temuan risiko tinggi yang masih berstatus Open.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-red-200 bg-white px-4 py-2 text-center">
                    <p class="text-2xl font-bold text-red-700">
                        {{ number_format($temuanPrioritas->count()) }}
                    </p>

                    <p class="text-xs font-semibold uppercase text-red-500">
                        Ditampilkan
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Nomor Temuan
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Bandar Udara
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Unsur / Elemen
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                Risiko
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($temuanPrioritas as $temuan)
                            <tr class="transition hover:bg-red-50/40">

                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="font-semibold text-gray-900">
                                        {{ $temuan->nomor_temuan }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Status: Open
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-700">
                                        {{ $temuan->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">
                                        {{ $temuan->unsur_elemen ?? '-' }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-lg border border-red-200 bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                        Risiko Tinggi
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a
                                        href="{{ route('temuan.show', $temuan) }}"
                                        class="inline-flex rounded-lg bg-red-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-red-700"
                                    >
                                        Lihat Detail
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center"
                                >
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-xl">
                                        ✓
                                    </div>

                                    <p class="mt-4 font-semibold text-gray-700">
                                        Tidak ada temuan prioritas
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Tidak terdapat temuan risiko tinggi yang masih Open.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Tabel --}}
        <div class="mt-6 grid gap-6 xl:grid-cols-2">

            {{-- Top bandara --}}
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">
                    <h2 class="text-lg font-bold text-gray-900">
                        Bandara dengan Temuan Terbanyak
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Lima bandar udara berdasarkan jumlah temuan.
                    </p>
                </div>

                <div class="divide-y divide-gray-100">

                    @forelse ($bandaraTerbanyak as $index => $bandara)
                        <a
                            href="{{ route('bandara.show', $bandara) }}"
                            class="flex items-center gap-4 px-6 py-4 transition hover:bg-gray-50"
                        >
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 font-bold text-gray-600">
                                {{ $index + 1 }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-gray-800">
                                    {{ $bandara->nama_bandara }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $bandara->kode_bandara ?? 'Kode belum tersedia' }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xl font-bold text-blue-600">
                                    {{ number_format($bandara->jumlah_temuan) }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    temuan
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-gray-500">
                            Data bandara belum tersedia.
                        </div>
                    @endforelse

                </div>

            </div>

            {{-- Temuan terbaru --}}
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            Temuan Terbaru
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Lima temuan yang terakhir ditambahkan.
                        </p>
                    </div>

                    <a
                        href="{{ route('temuan.index') }}"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                    >
                        Lihat semua
                    </a>
                </div>

                <div class="divide-y divide-gray-100">

                    @forelse ($temuanTerbaru as $temuan)
                        @php
                            $statusClass = $temuan->status === 'Close'
                                ? 'border-green-200 bg-green-50 text-green-700'
                                : 'border-red-200 bg-red-50 text-red-700';

                            $risikoClass = $temuan->tingkat_risiko === 'Tinggi'
                                ? 'text-red-600'
                                : 'text-green-600';
                        @endphp

                        <a
                            href="{{ route('temuan.show', $temuan) }}"
                            class="block px-6 py-4 transition hover:bg-gray-50"
                        >
                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-gray-800">
                                        {{ $temuan->nomor_temuan }}
                                    </p>

                                    <p class="mt-1 truncate text-sm text-gray-500">
                                        {{ $temuan->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                    </p>

                                    <p class="mt-2 text-xs font-semibold {{ $risikoClass }}">
                                        Risiko {{ $temuan->tingkat_risiko }}
                                    </p>
                                </div>

                                <span class="shrink-0 rounded-lg border px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                    {{ $temuan->status }}
                                </span>

                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-10 text-center text-sm text-gray-500">
                            Data temuan belum tersedia.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const elemenJam = document.getElementById('jam-dashboard');

        function perbaruiJam() {
            const sekarang = new Date();

            elemenJam.textContent = sekarang.toLocaleTimeString(
                'id-ID',
                {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }
            );
        }

        perbaruiJam();
        setInterval(perbaruiJam, 1000);
    });
</script>
@endsection
