@extends('layouts.app')

@section('title', 'Dashboard | SITBA')
@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6 py-6">

    {{-- Executive Hero --}}
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-br
               from-[#081a4a] via-[#0d2b7e] to-[#1556f6]
               text-white shadow-xl shadow-blue-950/20"
    >
        {{-- Decorative circles --}}
        <div class="pointer-events-none absolute -right-24 -top-40 h-[520px] w-[520px] rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute right-16 top-10 h-[360px] w-[360px] rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute right-40 top-28 h-[210px] w-[210px] rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-32 left-1/3 h-80 w-80 rounded-full bg-sky-400/10 blur-3xl"></div>

        <div class="relative p-6 md:p-8">

            {{-- Institution identity --}}
            <div class="flex items-center gap-3 border-b border-white/10 pb-5">

                
<div class="relative flex h-16 w-16 shrink-0 items-center justify-center">

    <div class="absolute inset-0 rounded-full bg-amber-300/20 blur-xl"></div>

    <img
        src="{{ asset('images/logo-kemenhub.png') }}"
        alt="Logo Kementerian Perhubungan"
        class="relative h-14 w-14 object-contain drop-shadow-2xl"
    >

</div>


                <div>
                    <p class="text-sm font-black uppercase tracking-[0.20em] text-amber-300">
                        KEMENTERIAN PERHUBUNGAN
                    </p>

                    <p class="mt-1 text-sm font-semibold text-blue-100">
                        Kantor Otoritas Bandar Udara Wilayah V Makassar
                    </p>

                    <p class="mt-1 text-xs tracking-wide text-blue-200">
                        Direktorat Jenderal Perhubungan Udara
                    </p>
                </div>

            </div>

            <div class="mt-7 grid gap-8 xl:grid-cols-[1fr_290px] xl:items-stretch">

                {{-- Main information --}}
                <div class="min-w-0">

                    <p class="text-sm font-bold text-sky-300">
                        Sistem Informasi Temuan Bandar Udara
                    </p>

                    <h2 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">
                        Selamat datang, {{ auth()->user()->name }}
                    </h2>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-100 md:text-base">
                        Pantau kegiatan inspeksi, temuan, tingkat risiko, dan progres
                        tindak lanjut bandar udara melalui satu dashboard terintegrasi.
                    </p>

                    {{-- Statistics --}}
                    <div class="mt-7 grid grid-cols-2 gap-3 md:grid-cols-4">

                        <div
                            class="group rounded-2xl border border-white/10 bg-white/[0.07]
                                   p-4 backdrop-blur-sm transition duration-300
                                   hover:-translate-y-1 hover:bg-white/[0.12]"
                        >
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M9 14h.01M9 18h.01M15 10h.01M15 14h.01M15 18h.01"/>
                                </svg>
                            </div>

                            <p
                                class="dashboard-counter mt-4 text-3xl font-black tabular-nums"
                                data-counter-target="{{ $jumlahBandara }}"
                                data-counter-suffix=""
                            >
                                0
                            </p>

                            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-blue-200">
                                Bandara
                            </p>
                        </div>

                        <div
                            class="group rounded-2xl border border-white/10 bg-white/[0.07]
                                   p-4 backdrop-blur-sm transition duration-300
                                   hover:-translate-y-1 hover:bg-white/[0.12]"
                        >
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5a3 3 0 016 0M9 12h6M9 16h6"/>
                                </svg>
                            </div>

                            <p
                                class="dashboard-counter mt-4 text-3xl font-black tabular-nums"
                                data-counter-target="{{ $jumlahInspeksi }}"
                                data-counter-suffix=""
                            >
                                0
                            </p>

                            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-blue-200">
                                Inspeksi
                            </p>
                        </div>

                        <div
                            class="group rounded-2xl border border-white/10 bg-white/[0.07]
                                   p-4 backdrop-blur-sm transition duration-300
                                   hover:-translate-y-1 hover:bg-white/[0.12]"
                        >
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.3 4.25L2.8 17.25A2 2 0 004.53 20h14.94a2 2 0 001.73-2.75l-7.5-13a2 2 0 00-3.4 0z"/>
                                </svg>
                            </div>

                            <p
                                class="dashboard-counter mt-4 text-3xl font-black tabular-nums"
                                data-counter-target="{{ $jumlahTemuan }}"
                                data-counter-suffix=""
                            >
                                0
                            </p>

                            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-blue-200">
                                Temuan
                            </p>
                        </div>

                        <div
                            class="group rounded-2xl border border-white/10 bg-white/[0.07]
                                   p-4 backdrop-blur-sm transition duration-300
                                   hover:-translate-y-1 hover:bg-white/[0.12]"
                        >
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-400/20 text-emerald-100">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M9 12.75l2.25 2.25L15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <p
                                class="dashboard-counter mt-4 text-3xl font-black tabular-nums"
                                data-counter-target="{{ round($persentaseClose) }}"
                                data-counter-suffix="%"
                            >
                                0%
                            </p>

                            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-blue-200">
                                Closed
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Date, clock and status --}}
                <div
                    class="flex flex-col justify-between rounded-3xl border border-white/15
                           bg-white/10 p-5 shadow-lg backdrop-blur-md"
                >
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-200">
                            Hari ini
                        </p>

                        <p class="mt-3 text-xl font-black">
                            {{ now()->translatedFormat('l') }}
                        </p>

                        <p class="mt-1 text-sm font-medium text-blue-100">
                            {{ now()->translatedFormat('d F Y') }}
                        </p>

                        <div class="my-5 h-px bg-white/15"></div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-blue-200">
                            📍 Makassar
                        </p>

                        <div class="mt-2 flex items-end justify-between gap-4">

                            <p
                                id="dashboard-live-clock"
                                class="text-3xl font-black tabular-nums tracking-tight"
                            >
                                {{ now()->format('H:i:s') }}
                            </p>

                            <span
                                class="mb-1 rounded-full border border-white/15 bg-white/10
                                       px-3 py-1 text-xs font-bold text-blue-100"
                            >
                                WITA
                            </span>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Executive overdue alert --}}
    @if ($tindakLanjutOverdue > 0)

        @php
            $daftarOverdueDashboard = $tindakLanjutMendesak
                ->filter(fn ($item) =>
                    $item->deadline
                    && $item->deadline->isPast()
                    && $item->temuan
                )
                ->take(3);
        @endphp

        <div
            class="overflow-hidden rounded-2xl border border-red-200
                   bg-gradient-to-r from-red-50 to-orange-50 shadow-sm"
        >
            <div class="flex flex-col gap-4 p-5 md:flex-row md:items-center md:justify-between">

                <div class="flex items-start gap-4">
                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center
                               rounded-2xl bg-red-100 text-xl"
                    >
                        ⚠
                    </div>

                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.14em] text-red-600">
                            Perhatian
                        </p>

                        <h3 class="mt-1 text-lg font-black text-slate-900">
                            {{ number_format($tindakLanjutOverdue) }} tindak lanjut terlambat
                        </h3>

                        <p class="mt-1 text-sm text-slate-600">
                            Klik temuan di bawah untuk membuka detail dan menindaklanjutinya.
                        </p>
                    </div>
                </div>

                <span
                    class="w-fit rounded-full bg-red-100 px-4 py-2
                           text-xs font-black uppercase tracking-wider text-red-700"
                >
                    Attention Required
                </span>

            </div>

            @if ($daftarOverdueDashboard->isNotEmpty())

                <div class="grid border-t border-red-100 md:grid-cols-3">

                    @foreach ($daftarOverdueDashboard as $tindakLanjut)

                        <a
                            href="{{ route('temuan.show', $tindakLanjut->temuan) }}"
                            class="group flex items-center justify-between gap-4 border-red-100
                                   px-5 py-4 transition hover:bg-white/80
                                   md:border-r md:last:border-r-0"
                        >
                            <div class="min-w-0">
                                <p class="truncate font-bold text-slate-900">
                                    {{ $tindakLanjut->temuan->nomor_temuan }}
                                </p>

                                <p class="mt-1 truncate text-xs text-slate-500">
                                    {{ $tindakLanjut->temuan->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                </p>

                                <p class="mt-2 text-xs font-bold text-red-600">
                                    Deadline {{ $tindakLanjut->deadline->format('d-m-Y') }}
                                </p>
                            </div>

                            <span
                                class="shrink-0 text-xl text-red-300 transition
                                       group-hover:translate-x-1 group-hover:text-red-600"
                            >
                                →
                            </span>
                        </a>

                    @endforeach

                </div>

            @endif
        </div>

    @endif

    

<style>
    /* Falcon Glassmorphism */
    [data-falcon-dashboard] {
        position: relative;
        isolation: isolate;
    }

    [data-falcon-dashboard]::before {
        content: "";
        position: fixed;
        z-index: -2;
        inset: 0;
        pointer-events: none;
        background:
            radial-gradient(
                circle at 8% 10%,
                rgba(59, 130, 246, 0.10),
                transparent 26%
            ),
            radial-gradient(
                circle at 92% 18%,
                rgba(99, 102, 241, 0.08),
                transparent 28%
            ),
            radial-gradient(
                circle at 55% 92%,
                rgba(14, 165, 233, 0.07),
                transparent 30%
            );
    }

    .falcon-glass {
        position: relative;
        background-color: rgba(255, 255, 255, 0.82) !important;
        border-color: rgba(203, 213, 225, 0.72) !important;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow:
            0 12px 35px rgba(15, 23, 42, 0.055),
            inset 0 1px 0 rgba(255, 255, 255, 0.72);
        transition:
            transform 280ms cubic-bezier(0.22, 1, 0.36, 1),
            box-shadow 280ms ease,
            border-color 280ms ease;
    }

    .falcon-glass:hover {
        border-color: rgba(148, 163, 184, 0.78) !important;
        box-shadow:
            0 18px 46px rgba(15, 23, 42, 0.09),
            inset 0 1px 0 rgba(255, 255, 255, 0.88);
    }

    .falcon-glass::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        border-radius: inherit;
        background:
            linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.28),
                transparent 42%
            );
        opacity: 0.72;
    }

    .falcon-glass > * {
        position: relative;
        z-index: 1;
    }

    .falcon-soft-glass {
        background-color: rgba(248, 250, 252, 0.72) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    @supports not (
        (backdrop-filter: blur(1px))
        or (-webkit-backdrop-filter: blur(1px))
    ) {
        .falcon-glass {
            background-color: rgba(255, 255, 255, 0.96) !important;
        }

        .falcon-soft-glass {
            background-color: rgba(248, 250, 252, 0.96) !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .falcon-glass {
            transition: none;
        }
    }
</style>

<style>
    /* Falcon Entrance Animation */
    .falcon-reveal {
        opacity: 0;
        transform: translateY(22px);
        transition:
            opacity 700ms cubic-bezier(0.22, 1, 0.36, 1),
            transform 700ms cubic-bezier(0.22, 1, 0.36, 1);
        transition-delay: var(--falcon-delay, 0ms);
        will-change: opacity, transform;
    }

    .falcon-reveal.falcon-visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (prefers-reduced-motion: reduce) {
        .falcon-reveal {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const clock = document.getElementById('dashboard-live-clock');

            if (clock) {
                const updateClock = function () {
                    const now = new Date();

                    clock.textContent = new Intl.DateTimeFormat('id-ID', {
                        timeZone: 'Asia/Makassar',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false,
                    }).format(now);
                };

                updateClock();
                setInterval(updateClock, 1000);
            }

            const counters = document.querySelectorAll('.dashboard-counter');

            const formatCounterValue = function (value) {
                return new Intl.NumberFormat('id-ID').format(value);
            };

            const animateCounter = function (counter) {
                const target = Number(
                    counter.dataset.counterTarget || 0
                );

                const suffix =
                    counter.dataset.counterSuffix || '';

                const duration = 1200;
                const startTime = performance.now();

                const updateCounter = function (currentTime) {
                    const elapsedTime =
                        currentTime - startTime;

                    const progress = Math.min(
                        elapsedTime / duration,
                        1
                    );

                    const easedProgress =
                        1 - Math.pow(1 - progress, 3);

                    const currentValue = Math.round(
                        target * easedProgress
                    );

                    counter.textContent =
                        formatCounterValue(currentValue) + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                };

                requestAnimationFrame(updateCounter);
            };

            counters.forEach(function (counter) {
                animateCounter(counter);
            });
        });
    </script>


    {{-- Executive Insight --}}
    @php
        $bandaraInsight = $bandaraAktifTerbanyak->first();
    @endphp

    <div
        class="overflow-hidden rounded-3xl border border-blue-100
               bg-gradient-to-br from-white via-blue-50/60 to-indigo-50
               shadow-sm"
    >
        <div class="grid gap-0 xl:grid-cols-[280px_1fr]">

            <div
                class="relative overflow-hidden bg-gradient-to-br
                       from-slate-950 via-blue-950 to-blue-800
                       p-6 text-white"
            >
                <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-blue-400/20 blur-3xl"></div>
                <div class="absolute -bottom-16 -left-10 h-36 w-36 rounded-full bg-indigo-400/20 blur-3xl"></div>

                <div class="relative">
                    <div
                        class="flex h-12 w-12 items-center justify-center
                               rounded-2xl border border-white/15 bg-white/10
                               text-2xl shadow-lg backdrop-blur"
                    >
                        ✦
                    </div>

                    <p class="mt-5 text-xs font-black uppercase tracking-[0.20em] text-blue-200">
                        Executive Insight
                    </p>

                    <h3 class="mt-2 text-2xl font-black tracking-tight">
                        Ringkasan Kondisi SITBA
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-blue-100">
                        Informasi utama untuk membantu pemantauan dan
                        pengambilan keputusan secara cepat.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 p-5 md:grid-cols-2 xl:grid-cols-4">

                <a
                    href="{{ route('temuan.index', ['tingkat_risiko' => 'Tinggi']) }}"
                    class="group rounded-2xl border border-red-100 bg-white p-5
                           transition duration-300 hover:-translate-y-1
                           hover:border-red-200 hover:shadow-md"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div
                            class="flex h-11 w-11 items-center justify-center
                                   rounded-2xl bg-red-50 text-xl"
                        >
                            ⚠️
                        </div>

                        <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-red-500">
                            →
                        </span>
                    </div>

                    <p class="mt-5 text-3xl font-black tabular-nums text-slate-900">
                        {{ number_format($executiveRisikoTinggi) }}
                    </p>

                    <p class="mt-1 text-sm font-bold text-slate-700">
                        Temuan Risiko Tinggi
                    </p>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Temuan risiko tinggi yang masih membutuhkan perhatian.
                    </p>
                </a>

                <a
                    href="{{ route('temuan.index', ['status' => 'Open']) }}"
                    class="group rounded-2xl border border-amber-100 bg-white p-5
                           transition duration-300 hover:-translate-y-1
                           hover:border-amber-200 hover:shadow-md"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div
                            class="flex h-11 w-11 items-center justify-center
                                   rounded-2xl bg-amber-50 text-xl"
                        >
                            🔎
                        </div>

                        <span class="text-slate-300 transition group-hover:translate-x-1 group-hover:text-amber-500">
                            →
                        </span>
                    </div>

                    <p class="mt-5 text-3xl font-black tabular-nums text-slate-900">
                        {{ number_format($executiveOpenUnsatisfactory) }}
                    </p>

                    <p class="mt-1 text-sm font-bold text-slate-700">
                        Open / Unsatisfactory
                    </p>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Temuan yang masih memerlukan penyelesaian.
                    </p>
                </a>

                <div
                    class="rounded-2xl border
                           {{ $totalOverdue > 0
                                ? 'border-red-100 bg-red-50/40'
                                : 'border-emerald-100 bg-emerald-50/40' }}
                           p-5 transition duration-300 hover:-translate-y-1
                           hover:shadow-md"
                >
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl
                               {{ $totalOverdue > 0
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-emerald-100 text-emerald-700' }}"
                    >
                        {{ $totalOverdue > 0 ? '!' : '✓' }}
                    </div>

                    <p class="mt-5 text-3xl font-black tabular-nums text-slate-900">
                        {{ number_format($totalOverdue) }}
                    </p>

                    <p class="mt-1 text-sm font-bold text-slate-700">
                        Total Temuan Overdue
                    </p>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        {{ $totalOverdue > 0
                            ? 'Temuan melewati batas waktu penyelesaian.'
                            : 'Tidak terdapat temuan overdue.' }}
                    </p>
                </div>

                <div
                    class="rounded-2xl border border-blue-100 bg-white p-5
                           transition duration-300 hover:-translate-y-1
                           hover:border-blue-200 hover:shadow-md"
                >
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-xl">
                        🏆
                    </div>

                    @if ($bandaraInsight)

                        <p class="mt-5 truncate text-lg font-black text-slate-900">
                            {{ $bandaraInsight->nama_bandara }}
                        </p>

                        <p class="mt-1 text-sm font-bold text-slate-700">
                            Temuan aktif terbanyak
                        </p>

                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            {{ number_format($bandaraInsight->jumlah_temuan) }}
                            temuan aktif tercatat pada bandara ini.
                        </p>

                    @else

                        <p class="mt-5 text-lg font-black text-slate-900">
                            Belum tersedia
                        </p>

                        <p class="mt-1 text-sm font-bold text-slate-700">
                            Data bandara
                        </p>

                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            Insight akan muncul setelah data temuan tersedia.
                        </p>

                    @endif
                </div>

            </div>

        </div>
    </div>


    {{-- Aksi Cepat --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Aksi Cepat
                </p>

                <h3 class="mt-1 text-lg font-bold text-slate-800">
                    Kelola data SITBA
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Akses langsung ke pekerjaan utama tanpa membuka menu satu per satu.
                </p>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                <a
                    href="{{ route('inspeksi.create') }}"
                    class="group flex items-center gap-3 rounded-xl border border-blue-200
                           bg-blue-50 px-4 py-3 transition hover:border-blue-300
                           hover:bg-blue-100"
                >
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                        📋
                    </span>

                    <span>
                        <span class="block text-sm font-bold text-blue-800">
                            Tambah Inspeksi
                        </span>

                        <span class="block text-xs text-blue-600">
                            Input kegiatan baru
                        </span>
                    </span>
                </a>


                <a
                    href="{{ route('temuan.create') }}"
                    class="group flex items-center gap-3 rounded-xl border border-amber-200
                           bg-amber-50 px-4 py-3 transition hover:border-amber-300
                           hover:bg-amber-100"
                >
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                        ⚠️
                    </span>

                    <span>
                        <span class="block text-sm font-bold text-amber-800">
                            Tambah Temuan
                        </span>

                        <span class="block text-xs text-amber-600">
                            Catat hasil inspeksi
                        </span>
                    </span>
                </a>


                <a
                    href="{{ route('laporan.create') }}"
                    class="group flex items-center gap-3 rounded-xl border border-emerald-200
                           bg-emerald-50 px-4 py-3 transition hover:border-emerald-300
                           hover:bg-emerald-100"
                >
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                        📄
                    </span>

                    <span>
                        <span class="block text-sm font-bold text-emerald-800">
                            Buat Laporan
                        </span>

                        <span class="block text-xs text-emerald-600">
                            Tutup dan verifikasi
                        </span>
                    </span>
                </a>


                <a
                    href="{{ route('temuan.index', ['status' => 'Open']) }}"
                    class="group flex items-center gap-3 rounded-xl border border-red-200
                           bg-red-50 px-4 py-3 transition hover:border-red-300
                           hover:bg-red-100"
                >
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                        🔎
                    </span>

                    <span>
                        <span class="block text-sm font-bold text-red-800">
                            Temuan Open
                        </span>

                        <span class="block text-xs text-red-600">
                            {{ number_format($temuanOpen) }} perlu dipantau
                        </span>
                    </span>
                </a>

            </div>

        </div>

    </div>


    {{-- Statistik utama --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <a
            href="{{ route('bandara.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                   transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-md"
        >
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Bandara
                    </p>

                    <p class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($jumlahBandara) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                    🛫
                </div>

            </div>

            <p class="mt-4 text-xs font-semibold text-blue-600">
                Lihat data bandara →
            </p>
        </a>


        <a
            href="{{ route('petugas.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                   transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md"
        >
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Inspektur
                    </p>

                    <p class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($jumlahPetugas) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-2xl">
                    👷
                </div>

            </div>

            <p class="mt-4 text-xs font-semibold text-indigo-600">
                Lihat data inspektur →
            </p>
        </a>


        <a
            href="{{ route('inspeksi.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                   transition hover:-translate-y-0.5 hover:border-cyan-200 hover:shadow-md"
        >
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Inspeksi
                    </p>

                    <p class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($jumlahInspeksi) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-2xl">
                    🔎
                </div>

            </div>

            <p class="mt-4 text-xs font-semibold text-cyan-600">
                Lihat kegiatan inspeksi →
            </p>
        </a>


        <a
            href="{{ route('temuan.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                   transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md"
        >
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Temuan
                    </p>

                    <p class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($jumlahTemuan) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-2xl">
                    ⚠️
                </div>

            </div>

            <p class="mt-4 text-xs font-semibold text-amber-600">
                Lihat seluruh temuan →
            </p>
        </a>


        <a
            href="{{ route('laporan.index') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                   transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
        >
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Laporan
                    </p>

                    <p class="mt-3 text-3xl font-bold text-slate-800">
                        {{ number_format($jumlahLaporan) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl">
                    📄
                </div>

            </div>

            <p class="mt-4 text-xs font-semibold text-emerald-600">
                Lihat laporan →
            </p>
        </a>

    </div>




    {{-- Grafik dashboard --}}
    <div class="grid gap-6">

        {{-- Tren temuan bulanan --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                        Analisis Temuan
                    </p>

                    <h3 class="mt-1 text-lg font-bold text-slate-800">
                        {{ $tahun
                            ? 'Tren Temuan per Bulan'
                            : 'Tren Temuan per Tahun' }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $tahun
                            ? 'Perbandingan temuan Open dan Close pada setiap bulan.'
                            : 'Perbandingan temuan Open dan Close pada setiap tahun.' }}
                    </p>
                </div>

                <span class="w-fit rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ $tahun ? 'Tahun ' . $tahun : 'Lintas tahun' }}
                </span>

            </div>

            @if ((
                    array_sum($dataTemuanOpenGrafik)
                    + array_sum($dataTemuanCloseGrafik)
                ) > 0)

                <div class="mt-6 h-72 sm:h-80">
                    <canvas id="grafikTemuanBulanan"></canvas>
                </div>

            @else

                <div class="mt-6 flex h-72 flex-col items-center justify-center rounded-xl bg-slate-50 text-center">

                    <div class="text-4xl">
                        📊
                    </div>

                    <p class="mt-3 font-semibold text-slate-700">
                        Belum ada data grafik
                    </p>

                    <p class="mt-1 max-w-sm text-sm text-slate-500">
                        Data temuan akan ditampilkan setelah kegiatan inspeksi
                        dan temuan ditambahkan.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- Status dan tindak lanjut --}}
    <div class="grid gap-6 xl:grid-cols-2">

        {{-- Status temuan --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Status Temuan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Progres penyelesaian seluruh temuan.
                    </p>
                </div>

                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ $persentaseSelesai }}% selesai
                </span>

            </div>

            <div class="mt-6 h-3 overflow-hidden rounded-full bg-slate-100">

                <div
                    class="h-full rounded-full bg-emerald-500 transition-all"
                    style="width: {{ min($persentaseSelesai, 100) }}%"
                ></div>

            </div>

            <div class="mt-6 grid grid-cols-2 gap-4">

                <div class="rounded-xl bg-red-50 p-4">

                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>

                        <span class="text-sm font-semibold text-red-700">
                            Open
                        </span>
                    </div>

                    <p class="mt-3 text-2xl font-bold text-red-800">
                        {{ number_format($temuanOpen) }}
                    </p>

                    <p class="mt-1 text-xs text-red-600">
                        {{ $persentaseOpen }}% dari temuan
                    </p>

                </div>

                <div class="rounded-xl bg-emerald-50 p-4">

                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                        <span class="text-sm font-semibold text-emerald-700">
                            Close
                        </span>
                    </div>

                    <p class="mt-3 text-2xl font-bold text-emerald-800">
                        {{ number_format($temuanClose) }}
                    </p>

                    <p class="mt-1 text-xs text-emerald-600">
                        {{ $persentaseClose }}% dari temuan
                    </p>

                </div>

            </div>

        </div>




        {{-- Tindak lanjut --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Monitoring Tindak Lanjut
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Pemantauan penyelesaian temuan.
                    </p>
                </div>

                @if ($tindakLanjutOverdue > 0)

                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                        {{ $tindakLanjutOverdue }} terlambat
                    </span>

                @else

                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                        Tidak ada terlambat
                    </span>

                @endif

            </div>

            <div class="mt-6 grid grid-cols-2 gap-4">

                <div class="rounded-xl border border-slate-200 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Belum selesai
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-800">
                        {{ number_format($tindakLanjutOpen) }}
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Sudah selesai
                    </p>

                    <p class="mt-2 text-2xl font-bold text-emerald-600">
                        {{ number_format($tindakLanjutClose) }}
                    </p>
                </div>

            </div>

            <div class="mt-5">

                <div class="mb-2 flex justify-between text-xs">
                    <span class="font-semibold text-slate-500">
                        Progres
                    </span>

                    <span class="font-bold text-slate-700">
                        {{ $persentaseTindakLanjutClose }}%
                    </span>
                </div>

                <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                    <div
                        class="h-full rounded-full bg-blue-600"
                        style="width: {{ min($persentaseTindakLanjutClose, 100) }}%"
                    ></div>

                </div>

            </div>

        </div>

    </div>





    {{-- Top 5 Temuan Prioritas --}}
    <div
        class="overflow-hidden rounded-3xl border border-slate-200
               bg-white shadow-sm"
    >

        <div class="border-b border-slate-100 px-6 py-5">

            <p class="text-xs font-black uppercase tracking-[0.16em] text-red-600">
                Monitoring Prioritas
            </p>

            <h3 class="mt-1 text-xl font-black text-slate-900">
                Top 5 Temuan Prioritas
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Temuan yang membutuhkan perhatian dan penyelesaian segera.
            </p>

        </div>


        <div class="divide-y divide-slate-100">

            @forelse ($topTemuanPrioritas as $index => $temuan)

                <div class="px-6 py-5 transition hover:bg-slate-50">

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center
                                   justify-center rounded-xl bg-red-50
                                   font-black text-red-700"
                        >
                            {{ $index + 1 }}
                        </div>

                        <div class="flex-1">

                            <h4 class="font-black text-slate-900">
                                {{ $temuan->nomor_temuan }}
                            </h4>

                            <p class="mt-1 text-sm text-slate-600">
                                {{ $temuan->inspeksi?->bandara?->nama_bandara ?? '-' }}
                            </p>

                            <div class="mt-2 flex flex-wrap gap-2">

                                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                    {{ $temuan->tingkat_risiko }}
                                </span>

                                @php
                                    $dueDate = \Carbon\Carbon::parse($temuan->due_date);
                                    $today = now()->startOfDay();
                                @endphp

                                @if ($dueDate->lt($today))

                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                        ⚠️ Terlambat {{ $dueDate->diffInDays($today) }} hari
                                    </span>

                                @elseif ($dueDate->equalTo($today))

                                    <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                                        ⏰ Jatuh tempo hari ini
                                    </span>

                                @else

                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">
                                        🟠 {{ $today->diffInDays($dueDate) }} hari lagi
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-10 text-center text-slate-500">
                    Belum ada temuan prioritas.
                </div>

            @endforelse

        </div>

    </div>


    {{-- Top 5 Bandara dengan Temuan Aktif Terbanyak --}}
    <div
        class="overflow-hidden rounded-3xl border border-slate-200
               bg-white shadow-sm"
    >

        <div
            class="border-b border-slate-100 px-6 py-5"
        >
            <p
                class="text-xs font-black uppercase
                       tracking-[0.16em] text-indigo-600"
            >
                Monitoring Prioritas
            </p>

            <h3 class="mt-1 text-xl font-black text-slate-900">
                Top 5 Bandara dengan Temuan Aktif Terbanyak
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Daftar bandara dengan jumlah temuan aktif terbanyak yang
                masih membutuhkan perhatian.
            </p>
        </div>


        <div class="divide-y divide-slate-100">

            @forelse ($bandaraAktifTerbanyak as $index => $bandara)

                <div
                    class="flex flex-col gap-4 px-6 py-5
                           transition hover:bg-slate-50
                           sm:flex-row sm:items-center
                           sm:justify-between"
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-2xl bg-blue-50
                                   text-lg font-black text-blue-700"
                        >
                            {{ $index + 1 }}
                        </div>


                        <div>

                            <h4 class="font-black text-slate-900">
                                {{ $bandara->nama_bandara }}
                            </h4>

                            <p class="mt-1 text-sm text-slate-500">
                                Temuan aktif:
                                <span class="font-bold text-slate-700">
                                    {{ $bandara->jumlah_temuan_aktif }}
                                </span>
                            </p>

                        </div>

                    </div>


                    <div class="flex items-center gap-3 text-sm">

                        <div
                            class="rounded-xl bg-amber-50 px-4 py-2"
                        >
                            <span class="font-bold text-amber-600">
                                Open
                            </span>

                            <span class="ml-1 font-black text-amber-700">
                                {{ $bandara->jumlah_open }}
                            </span>
                        </div>


                        <div
                            class="rounded-xl bg-emerald-50 px-4 py-2"
                        >
                            <span class="font-bold text-emerald-600">
                                Close
                            </span>

                            <span class="ml-1 font-black text-emerald-700">
                                {{ $bandara->jumlah_close }}
                            </span>
                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-14 text-center text-slate-500">
                    Belum ada data temuan bandara.
                </div>

            @endforelse

        </div>

    </div>


    {{-- Activity Timeline --}}
    @php
        $aktivitasDashboard = ($activities ?? collect())
            ->map(function ($log) {

                return [
                    'jenis' => strtolower($log->model),
                    'judul' => ucfirst($log->action) . ' ' . strtolower($log->model),
                    'deskripsi' => $log->description,
                    'bandara' => '-',
                    'status' => ucfirst($log->action),
                    'waktu' => $log->created_at,
                    'url' => '#',
                ];

            });
    @endphp

    <div
        class="overflow-hidden rounded-3xl border border-slate-200
               bg-white shadow-sm"
    >
        <div
            class="flex flex-col gap-4 border-b border-slate-100
                   px-6 py-5 sm:flex-row sm:items-center
                   sm:justify-between"
        >
            <div>
                <p
                    class="text-xs font-black uppercase tracking-[0.16em]
                           text-blue-600"
                >
                    Live Monitoring
                </p>

                <h3 class="mt-1 text-xl font-black text-slate-900">
                    Aktivitas dan Pembaruan Terbaru
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Ringkasan perubahan data temuan dan tindak lanjut terkini.
                </p>
            </div>

            <div
                class="flex w-fit items-center gap-2 rounded-full
                       bg-emerald-50 px-3 py-2 text-xs font-bold
                       text-emerald-700"
            >
                <span class="relative flex h-2.5 w-2.5">
                    <span
                        class="absolute inline-flex h-full w-full
                               animate-ping rounded-full bg-emerald-400
                               opacity-75"
                    ></span>

                    <span
                        class="relative inline-flex h-2.5 w-2.5
                               rounded-full bg-emerald-500"
                    ></span>
                </span>

                Data terkini
            </div>
        </div>

        @if ($aktivitasDashboard->isNotEmpty())

            <div class="relative px-6 py-2">

                <div
                    class="absolute bottom-8 left-[45px] top-8
                           w-px bg-slate-200"
                ></div>

                <div class="divide-y divide-slate-100">

                    @foreach ($aktivitasDashboard as $aktivitas)

                        @php
                            $isCreate = strtolower($aktivitas['status']) === 'create';
                            $isUpdate = strtolower($aktivitas['status']) === 'update';
                            $isDelete = strtolower($aktivitas['status']) === 'delete';
                        @endphp

                        <a
                            href="{{ $aktivitas['url'] }}"
                            class="group relative flex gap-5 py-5"
                        >
                            <div
                                class="relative z-10 flex h-10 w-10 shrink-0
                                       items-center justify-center rounded-2xl
                                       border-4 border-white shadow-sm
                                       {{ $isDelete
                                            ? 'bg-red-100 text-red-700'
                                            : ($isCreate
                                                ? 'bg-emerald-100 text-emerald-700'
                                                : ($isUpdate
                                                    ? 'bg-blue-100 text-blue-700'
                                                    : 'bg-slate-100 text-slate-700')) }}"
                            >
                                @if ($isDelete)
                                    ×
                                @elseif ($isCreate)
                                    +
                                @elseif ($isUpdate)
                                    ↻
                                @else
                                    •
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">

                                <div
                                    class="flex flex-col gap-2 sm:flex-row
                                           sm:items-start
                                           sm:justify-between"
                                >
                                    <div class="min-w-0">

                                        <div
                                            class="flex flex-wrap
                                                   items-center gap-2"
                                        >
                                            <p
                                                class="font-bold text-slate-900
                                                       transition
                                                       group-hover:text-blue-700"
                                            >
                                                {{ $aktivitas['judul'] }}
                                            </p>

                                            <span
                                                class="rounded-full px-2.5 py-1
                                                       text-[11px] font-black
                                                       uppercase tracking-wide
                                                       {{ $isDelete
                                                            ? 'bg-red-100 text-red-700'
                                                            : ($isCreate
                                                                ? 'bg-emerald-100 text-emerald-700'
                                                                : ($isUpdate
                                                                    ? 'bg-amber-100 text-amber-700'
                                                                    : 'bg-blue-100 text-blue-700')) }}"
                                            >
                                                {{ $aktivitas['status'] }}
                                            </span>
                                        </div>

                                        <p
                                            class="mt-1 line-clamp-1
                                                   text-sm text-slate-600"
                                        >
                                            {{ $aktivitas['deskripsi'] }}
                                        </p>

                                        <p class="mt-2 text-xs text-slate-400">
                                            {{ $aktivitas['bandara'] }}
                                        </p>
                                    </div>

                                    <div
                                        class="flex shrink-0 items-center
                                               gap-3 sm:pl-4"
                                    >
                                        <span
                                            class="text-xs font-semibold
                                                   text-slate-400"
                                        >
                                            {{ optional($aktivitas['waktu'])->diffForHumans() }}
                                        </span>

                                        <span
                                            class="text-slate-300 transition
                                                   group-hover:translate-x-1
                                                   group-hover:text-blue-600"
                                        >
                                            →
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </a>

                    @endforeach

                </div>

            </div>

        @else

            <div class="px-6 py-14 text-center">

                <div
                    class="mx-auto flex h-14 w-14 items-center
                           justify-center rounded-2xl bg-slate-100
                           text-2xl"
                >
                    ◷
                </div>

                <p class="mt-4 font-bold text-slate-700">
                    Belum ada aktivitas terbaru
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Pembaruan akan muncul setelah data SITBA ditambahkan.
                </p>
            </div>

        @endif
    </div>


    {{-- Temuan prioritas dan terbaru --}}
    <div class="grid gap-6 xl:grid-cols-2">

        {{-- Prioritas --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Temuan Prioritas
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Temuan Risiko Tinggi yang masih Open.
                    </p>
                </div>

                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                    Perlu perhatian
                </span>

            </div>

            <div class="divide-y divide-slate-100">

                @forelse ($temuanPrioritas as $temuan)

                    <a
                        href="{{ route('temuan.show', $temuan) }}"
                        class="block px-6 py-4 transition hover:bg-slate-50"
                    >

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="font-semibold text-slate-800">
                                        {{ $temuan->nomor_temuan }}
                                    </span>

                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Risiko Tinggi
                                    </span>

                                </div>

                                <p class="mt-2 truncate text-sm text-slate-600">
                                    {{ $temuan->uraian_temuan }}
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    {{ $temuan->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                </p>

                            </div>

                            <span class="shrink-0 text-slate-400">
                                →
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="px-6 py-12 text-center">

                        <div class="text-3xl">
                            ✅
                        </div>

                        <p class="mt-3 font-semibold text-slate-700">
                            Tidak ada temuan prioritas
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Tidak terdapat temuan risiko tinggi berstatus Open.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- Temuan terbaru --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Temuan Terbaru
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
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

            <div class="divide-y divide-slate-100">

                @forelse ($temuanTerbaru as $temuan)

                    <a
                        href="{{ route('temuan.show', $temuan) }}"
                        class="block px-6 py-4 transition hover:bg-slate-50"
                    >

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    <span class="font-semibold text-slate-800">
                                        {{ $temuan->nomor_temuan }}
                                    </span>

                                    @if ($temuan->status === 'Close')

                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Close
                                        </span>

                                    @else

                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            Open
                                        </span>

                                    @endif

                                </div>

                                <p class="mt-2 truncate text-sm text-slate-600">
                                    {{ $temuan->uraian_temuan }}
                                </p>

                                <p class="mt-2 text-xs text-slate-400">
                                    {{ $temuan->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                </p>

                            </div>

                            <span class="shrink-0 text-slate-400">
                                →
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="px-6 py-12 text-center">

                        <div class="text-3xl">
                            📋
                        </div>

                        <p class="mt-3 font-semibold text-slate-700">
                            Belum ada data temuan
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- Deadline tindak lanjut --}}
    <div class="grid gap-6">




        {{-- Deadline tindak lanjut --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>
                    <h3 class="font-bold text-slate-800">
                        Deadline Tindak Lanjut
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Daftar tindak lanjut yang perlu dipantau.
                    </p>
                </div>

                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                    {{ $tindakLanjutMendesak->count() }} data
                </span>

            </div>

            <div class="divide-y divide-slate-100">

                @forelse ($tindakLanjutMendesak as $tindakLanjut)

                    @php
                        $terlambat = $tindakLanjut->deadline
                            && $tindakLanjut->deadline->isPast();
                    @endphp

                    @if ($tindakLanjut->temuan)

                        <a
                            href="{{ route(
                                'temuan.show',
                                $tindakLanjut->temuan
                            ) }}"
                            class="group block px-6 py-4 transition
                                   hover:bg-slate-50"
                        >

                    @else

                        <div class="px-6 py-4">

                    @endif

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <p class="font-semibold text-slate-800">
                                    {{ $tindakLanjut->temuan?->nomor_temuan ?? 'Temuan tidak tersedia' }}
                                </p>

                                <p class="mt-1 truncate text-sm text-slate-500">
                                    {{ $tindakLanjut->temuan?->inspeksi?->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                </p>

                            </div>

                            <div class="flex shrink-0 items-center gap-3">

                                <div class="text-right">

                                    <p class="text-sm font-semibold {{ $terlambat ? 'text-red-600' : 'text-amber-600' }}">
                                        {{ $tindakLanjut->deadline?->format('d-m-Y') ?? '-' }}
                                    </p>

                                    <p class="mt-1 text-xs {{ $terlambat ? 'text-red-500' : 'text-slate-400' }}">
                                        {{ $terlambat ? 'Terlambat' : 'Belum jatuh tempo' }}
                                    </p>

                                </div>

                                @if ($tindakLanjut->temuan)

                                    <span class="text-slate-300 transition
                                                 group-hover:translate-x-0.5
                                                 group-hover:text-blue-500">
                                        →
                                    </span>

                                @endif

                            </div>

                        </div>

                    @if ($tindakLanjut->temuan)

                        </a>

                    @else

                        </div>

                    @endif

                @empty

                    <div class="px-6 py-12 text-center">

                        <div class="text-3xl">
                            🎉
                        </div>

                        <p class="mt-3 font-semibold text-slate-700">
                            Tidak ada deadline aktif
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Belum ada tindak lanjut yang perlu dipantau.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dashboardContainer =
            document.querySelector('[data-falcon-dashboard]')
            ?? document.querySelector('main')
            ?? document.body;

        const animatedElements = Array.from(
            dashboardContainer.querySelectorAll(
                ':scope > div, :scope > section'
            )
        );

        animatedElements.forEach(function (element, index) {
            element.classList.add('falcon-reveal');

            const delay = Math.min(index * 85, 680);

            element.style.setProperty(
                '--falcon-delay',
                delay + 'ms'
            );
        });

        const observer = new IntersectionObserver(
            function (entries, revealObserver) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('falcon-visible');
                    revealObserver.unobserve(entry.target);
                });
            },
            {
                threshold: 0.08,
                rootMargin: '0px 0px -35px 0px',
            }
        );

        animatedElements.forEach(function (element) {
            observer.observe(element);
        });

        window.setTimeout(function () {
            animatedElements.forEach(function (element) {
                element.classList.add('falcon-visible');
            });
        }, 1600);
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dashboard =
            document.querySelector('[data-falcon-dashboard]');

        if (!dashboard) {
            return;
        }

        const glassCandidates = dashboard.querySelectorAll(
            [
                '.rounded-2xl.bg-white',
                '.rounded-3xl.bg-white',
                '.rounded-2xl[class*="bg-white"]',
                '.rounded-3xl[class*="bg-white"]'
            ].join(',')
        );

        glassCandidates.forEach(function (element) {
            const isSmallNestedElement =
                element.closest('.falcon-glass');

            if (!isSmallNestedElement) {
                element.classList.add('falcon-glass');
            }
        });

        const softCandidates = dashboard.querySelectorAll(
            [
                '.bg-slate-50',
                '.bg-gray-50',
                '.bg-blue-50\\/40',
                '.bg-blue-50\\/60',
                '.bg-red-50\\/40',
                '.bg-emerald-50\\/40'
            ].join(',')
        );

        softCandidates.forEach(function (element) {
            element.classList.add('falcon-soft-glass');
        });
    });
</script>


@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labelGrafikTemuan = @json($labelGrafikTemuan);
        const dataTemuanOpenGrafik = @json($dataTemuanOpenGrafik);
        const dataTemuanCloseGrafik = @json($dataTemuanCloseGrafik);

        const jumlahRisikoRendah = @json($risikoRendah);
        const jumlahRisikoTinggi = @json($risikoTinggi);

        const elemenGrafikBulanan = document.getElementById(
            'grafikTemuanBulanan'
        );

        if (elemenGrafikBulanan && window.Chart) {
            new Chart(elemenGrafikBulanan, {
                type: 'bar',

                data: {
                    labels: labelGrafikTemuan,

                    datasets: [
                        {
                            label: 'Open',
                            data: dataTemuanOpenGrafik,
                            backgroundColor: 'rgba(239, 68, 68, 0.82)',
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 1,
                            borderRadius: 7,
                            borderSkipped: false,
                            maxBarThickness: 48,
                        },
                        {
                            label: 'Close',
                            data: dataTemuanCloseGrafik,
                            backgroundColor: 'rgba(16, 185, 129, 0.82)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1,
                            borderRadius: 7,
                            borderSkipped: false,
                            maxBarThickness: 48,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },

                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',

                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                boxHeight: 8,
                                padding: 18,
                                color: '#475569',

                                font: {
                                    size: 12,
                                    weight: '600',
                                },
                            },
                        },

                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return (
                                        ' ' +
                                        context.dataset.label +
                                        ': ' +
                                        context.raw +
                                        ' temuan'
                                    );
                                },

                                footer: function (items) {
                                    const total = items.reduce(
                                        function (jumlah, item) {
                                            return jumlah + item.raw;
                                        },
                                        0
                                    );

                                    return 'Total: ' + total + ' temuan';
                                },
                            },
                        },
                    },

                    scales: {
                        x: {
                            stacked: true,

                            grid: {
                                display: false,
                            },

                            ticks: {
                                color: '#64748b',

                                font: {
                                    size: 11,
                                    weight: '600',
                                },
                            },
                        },

                        y: {
                            stacked: true,
                            beginAtZero: true,

                            ticks: {
                                precision: 0,
                                stepSize: 1,
                                color: '#64748b',
                            },

                            grid: {
                                color: 'rgba(148, 163, 184, 0.18)',
                            },
                        },
                    },
                },
            });
        }


        const elemenGrafikRisiko = document.getElementById(
            'grafikDistribusiRisiko'
        );

        if (elemenGrafikRisiko && window.Chart) {
            new Chart(elemenGrafikRisiko, {
                type: 'doughnut',

                data: {
                    labels: [
                        'Risiko Rendah',
                        'Risiko Tinggi',
                    ],

                    datasets: [
                        {
                            data: [
                                jumlahRisikoRendah,
                                jumlahRisikoTinggi,
                            ],

                            backgroundColor: [
                                'rgb(16, 185, 129)',
                                'rgb(239, 68, 68)',
                            ],

                            borderColor: '#ffffff',
                            borderWidth: 5,
                            hoverOffset: 8,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',

                    plugins: {
                        legend: {
                            display: false,
                        },

                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const data = context.dataset.data;

                                    const total = data.reduce(
                                        function (jumlah, nilai) {
                                            return jumlah + nilai;
                                        },
                                        0
                                    );

                                    const persentase = total > 0
                                        ? Math.round(
                                            (context.raw / total) * 100
                                        )
                                        : 0;

                                    return (
                                        ' ' +
                                        context.label +
                                        ': ' +
                                        context.raw +
                                        ' (' +
                                        persentase +
                                        '%)'
                                    );
                                },
                            },
                        },
                    },
                },
            });
        }
    });
</script>

@endpush
