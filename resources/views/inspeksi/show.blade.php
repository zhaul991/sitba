@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Detail Inspeksi
            </h1>

            <p class="mt-2 text-gray-500">
                Informasi lengkap kegiatan inspeksi bandar udara.
            </p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('inspeksi.index') }}"
               class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                Kembali
            </a>

            <a href="{{ route('inspeksi.edit', $inspeksi) }}"
               class="rounded-xl bg-amber-500 px-5 py-3 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                Edit Inspeksi
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">

        <div class="space-y-6 lg:col-span-2">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-gray-800">
                    Informasi Inspeksi
                </h2>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Bandara
                        </p>

                        <p class="mt-2 text-base font-bold text-gray-800">
                            {{ $inspeksi->bandara->nama_bandara }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $inspeksi->bandara->kode_bandara ?: '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">
                            Tanggal Inspeksi
                        </p>

                        <p class="mt-2 text-base font-bold text-gray-800">
                            {{ $inspeksi->tanggal->format('d-m-Y') }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 border-t border-gray-100 pt-6">
                    <p class="text-sm font-semibold text-gray-500">
                        Keterangan
                    </p>

                    <p class="mt-2 whitespace-pre-line text-gray-700">
                        {{ $inspeksi->keterangan ?: 'Tidak ada keterangan.' }}
                    </p>
                </div>

            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Daftar Temuan
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Temuan yang tercatat pada kegiatan inspeksi ini.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-semibold text-red-700">
                            {{ $inspeksi->temuans->count() }} Temuan
                        </span>

                        <a href="{{ route('temuan.create', ['inspeksi_id' => $inspeksi->id]) }}"
                           class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                            + Tambah Temuan
                        </a>
                    </div>
                </div>

                <div class="mt-6">

                    @forelse ($inspeksi->temuans as $temuan)

                        <div class="mb-3 rounded-xl border border-gray-200 p-4 last:mb-0">

                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $temuan->judul ?? 'Temuan Inspeksi' }}
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $temuan->deskripsi ?? $temuan->uraian ?? '-' }}
                                    </p>
                                </div>

                                <span class="rounded-lg bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                    {{ $temuan->status ?? 'Belum diproses' }}
                                </span>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-gray-300 px-5 py-10 text-center">

                            <div class="text-4xl">
                                📋
                            </div>

                            <p class="mt-3 font-semibold text-gray-700">
                                Belum ada temuan
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Temuan hasil inspeksi nantinya akan tampil di bagian ini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="space-y-6">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-bold text-gray-800">
                    Tim Inspektur
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Inspektur yang ditugaskan pada kegiatan ini.
                </p>

                <div class="mt-6 space-y-3">

                    @forelse ($inspeksi->petugas as $inspektur)

                        <div class="rounded-xl border border-gray-200 p-4">

                            <p class="font-semibold text-gray-800">
                                {{ $inspektur->nama_petugas }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                NIP: {{ $inspektur->nip }}
                            </p>

                        </div>

                    @empty

                        <p class="text-sm text-gray-500">
                            Belum ada inspektur yang dipilih.
                        </p>

                    @endforelse

                </div>

            </div>

            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6">

                <p class="text-sm font-semibold text-blue-700">
                    ID Inspeksi
                </p>

                <p class="mt-2 text-2xl font-bold text-blue-900">
                    #{{ $inspeksi->id }}
                </p>

                <p class="mt-3 text-sm text-blue-700">
                    Dibuat pada {{ $inspeksi->created_at?->format('d-m-Y H:i') ?? '-' }}
                </p>

            </div>

        </div>

    </div>

</div>
@endsection
