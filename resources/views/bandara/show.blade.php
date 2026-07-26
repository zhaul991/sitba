@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a
                href="{{ route('bandara.index') }}"
                class="mb-3 inline-flex items-center text-sm font-semibold text-blue-600 transition hover:text-blue-800"
            >
                ← Kembali ke Data Bandara
            </a>

            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-bold text-slate-800">
                    {{ $bandara->nama_bandara }}
                </h1>

                <span class="rounded-lg bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                    {{ $bandara->kode_bandara }}
                </span>
            </div>

            <p class="mt-2 text-slate-500">
                {{ $bandara->lokasi }}
            </p>
        </div>

        <a
            href="{{ route('bandara.edit', $bandara) }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            Edit Bandara
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <x-stat-card
            label="Inspeksi Terakhir"
            :value="$inspeksiTerakhir
                ? $inspeksiTerakhir->tanggal->translatedFormat('d F Y')
                : 'Belum ada'"
            icon="📅"
        />

        <x-stat-card
            label="Jumlah Inspeksi"
            :value="number_format($jumlahInspeksi)"
            tone="blue"
            icon="✈️"
        />

        <x-stat-card
            label="Total Temuan"
            :value="number_format($totalTemuan)"
            icon="📋"
        />

        <x-stat-card
            label="Temuan Open"
            :value="number_format($temuanOpen)"
            tone="amber"
            icon="●"
        />

        <x-stat-card
            label="Temuan Close"
            :value="number_format($temuanClose)"
            tone="green"
            icon="✓"
        />

    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

        <x-section-card
            title="5 Inspeksi Terakhir"
            description="Riwayat kegiatan inspeksi terbaru pada bandara ini."
        >
            <div class="divide-y divide-slate-100">
                @forelse ($inspeksiTerbaru as $inspeksi)
                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-bold text-slate-800">
                                {{ $inspeksi->tanggal->translatedFormat('d F Y') }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $inspeksi->petugas->pluck('nama_petugas')->join(', ') ?: 'Belum ada inspektur' }}
                            </p>

                            <p class="mt-2 text-sm text-slate-600">
                                {{ $inspeksi->temuans_count }} temuan
                            </p>
                        </div>

                        <a
                            href="{{ route('inspeksi.show', $inspeksi) }}"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                        >
                            Lihat Inspeksi →
                        </a>
                    </div>
                @empty
                    <x-empty-state
                        title="Belum ada data inspeksi"
                        description="Kegiatan inspeksi pada bandara ini belum tersedia."
                        icon="✈️"
                    />
                @endforelse
            </div>
        </x-section-card>

        <x-section-card
            title="5 Temuan Terbaru"
            description="Temuan terbaru dari seluruh kegiatan inspeksi."
        >
            <div class="divide-y divide-slate-100">
                @forelse ($temuanTerbaru as $temuan)
                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="font-bold text-slate-800">
                                    {{ $temuan->nomor_temuan }}
                                </p>

                                <span
                                    @class([
                                        'rounded-lg px-2.5 py-1 text-xs font-bold',
                                        'bg-amber-50 text-amber-700' => $temuan->status === 'Open',
                                        'bg-green-50 text-green-700' => $temuan->status === 'Close',
                                    ])
                                >
                                    {{ $temuan->status }}
                                </span>

                                <span
                                    @class([
                                        'rounded-lg px-2.5 py-1 text-xs font-bold',
                                        'bg-red-50 text-red-700' => $temuan->tingkat_risiko === 'Tinggi',
                                        'bg-blue-50 text-blue-700' => $temuan->tingkat_risiko === 'Rendah',
                                    ])
                                >
                                    Risiko {{ $temuan->tingkat_risiko }}
                                </span>
                            </div>

                            <p class="mt-2 text-sm text-slate-600">
                                {{ \Illuminate\Support\Str::limit($temuan->uraian_temuan, 90) }}
                            </p>

                            <p class="mt-2 text-xs text-slate-400">
                                Inspeksi:
                                {{ optional($temuan->inspeksi?->tanggal)->translatedFormat('d F Y') ?? '-' }}
                            </p>
                        </div>

                        <a
                            href="{{ route('temuan.show', $temuan) }}"
                            class="inline-flex shrink-0 items-center justify-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                        >
                            Lihat Temuan →
                        </a>
                    </div>
                @empty
                    <x-empty-state
                        title="Belum ada data temuan"
                        description="Temuan pada bandara ini belum tersedia."
                        icon="📋"
                    />
                @endforelse
            </div>
        </x-section-card>

    </div>

</div>
@endsection
