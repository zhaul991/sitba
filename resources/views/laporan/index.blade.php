@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Modul Laporan
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900">
                    Arsip Laporan Tindak Lanjut
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Penyimpanan surat tindak lanjut yang disampaikan oleh bandar udara.
                </p>
            </div>

            @if(auth()->user()->canModify())

            <a href="{{ route('laporan.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                + Tambah Laporan
            </a>

            @endif

        </div>
    </div>


    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Filter --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <form method="GET"
              action="{{ route('laporan.index') }}"
              class="grid gap-4 md:grid-cols-2 xl:grid-cols-5 xl:items-end">

            <div>
                <label for="bandara_id"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Bandara
                </label>

                <select id="bandara_id"
                        name="bandara_id"
                        class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">Semua Bandara</option>

                    @foreach ($bandaras as $bandara)
                        <option value="{{ $bandara->id }}"
                            @selected((string) request('bandara_id') === (string) $bandara->id)>
                            {{ $bandara->nama_bandara }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div>
                <label for="tahun"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Tahun
                </label>

                <select id="tahun"
                        name="tahun"
                        class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">Semua Tahun</option>

                    @foreach ($daftarTahun as $itemTahun)
                        <option value="{{ $itemTahun }}"
                            @selected((string) request('tahun') === (string) $itemTahun)>
                            {{ $itemTahun }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div>
                <label for="q"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Nomor Surat
                </label>

                <input id="q"
                       type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari nomor surat..."
                       class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>


            <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                Terapkan Filter
            </button>


            <a href="{{ route('laporan.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                Reset
            </a>

        </form>

    </div>


    {{-- Tabel --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900">
                        Daftar Surat Tindak Lanjut
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ number_format($laporans->total()) }} laporan ditemukan
                    </p>
                </div>
            </div>
        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Nomor Surat
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Bandara
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Tanggal Surat
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Dokumen
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($laporans as $laporan)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $laporans->firstItem() + $loop->index }}
                            </td>


                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">
                                    {{ $laporan->nomor_surat }}
                                </p>

                                @if ($laporan->perihal)
                                    <p class="mt-1 max-w-xs truncate text-sm text-gray-500">
                                        {{ $laporan->perihal }}
                                    </p>
                                @endif
                            </td>


                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $laporan->bandara->nama_bandara ?? '-' }}
                            </td>


                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $laporan->tanggal_surat?->format('d-m-Y') ?? '-' }}
                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                @if ($laporan->temuans_count > 0)
                                    <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        Close
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        Open
                                    </span>
                                @endif

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($laporan->file_surat)
                                    <a href="{{ asset('storage/' . $laporan->file_surat) }}"
                                       target="_blank"
                                       class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                        Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">
                                        Tidak ada
                                    </span>
                                @endif
                            </td>


                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                @if(auth()->user()->canModify())

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('laporan.edit', $laporan) }}"
                                       class="rounded-lg border border-yellow-200 bg-yellow-50 px-3 py-2 text-xs font-semibold text-yellow-700 hover:bg-yellow-100">
                                        Edit
                                    </a>


                                    <form action="{{ route('laporan.destroy', $laporan) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                                @endif

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-14 text-center">

                                <p class="font-semibold text-gray-700">
                                    Belum ada laporan tindak lanjut
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan surat tindak lanjut untuk menampilkan arsip.
                                </p>

                            </td>

                        </tr>


                                <td colspan="6"
                                    class="px-6 py-14 text-center">

                                    <p class="font-semibold text-gray-700">
                                        Belum ada laporan tindak lanjut
                                    </p>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Tambahkan laporan atau ubah filter pencarian.
                                    </p>

                                    @if(auth()->user()->canModify())

                                    <a href="{{ route('laporan.create') }}"
                                       class="mt-5 inline-flex rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                                        + Tambah Laporan
                                    </a>

                                    @endif

                                </td>

                            </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($laporans->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $laporans->links() }}
            </div>
        @endif

    </div>

</div>



@endsection
