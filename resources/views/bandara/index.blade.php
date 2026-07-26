@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">

    {{-- Header halaman --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Bandara
            </h1>

            <p class="mt-2 text-gray-500">
                Kelola daftar bandar udara yang terdaftar dalam sistem SITBA.
            </p>
        </div>

        <a href="{{ route('bandara.create') }}"
           class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">

            + Tambah Bandara

        </a>

    </div>


    {{-- Pesan sukses --}}
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- Card utama --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Search --}}
        <div class="border-b border-gray-200 p-5">

            <form method="GET"
                  action="{{ route('bandara.index') }}"
                  class="flex flex-col gap-3 sm:flex-row">

                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Cari nama bandara, kode, atau lokasi..."
                    class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                    Cari

                </button>

                @if (request('keyword'))

                    <a href="{{ route('bandara.index') }}"
                       class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">

                        Reset

                    </a>

                @endif

            </form>

        </div>


        {{-- Tabel --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Nama Bandara
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Kode
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Lokasi
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($bandaras as $bandara)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $bandaras->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">

                                <a
                                    href="{{ route('bandara.show', $bandara) }}"
                                    class="inline-flex items-center gap-2 font-semibold text-gray-800 transition hover:text-blue-600"
                                >
                                    {{ $bandara->nama_bandara }}

                                    <span class="text-sm text-gray-400">
                                        →
                                    </span>
                                </a>

                            </td>

                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="rounded-lg bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                                    {{ $bandara->kode_bandara }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $bandara->lokasi }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">

                                @if ($bandara->status === 'Aktif')

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('bandara.show', $bandara) }}"
                                        class="rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                                    >
                                        Detail
                                    </a>

                                    <a href="{{ route('bandara.edit', $bandara) }}"
                                       class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('bandara.destroy', $bandara) }}"
                                        method="POST"
                                        onsubmit="return confirm('⚠️ PERINGATAN PENGHAPUSAN DATA!\n\nData bandara ini akan dihapus beserta seluruh data inspeksi, temuan, foto dokumentasi, dan tindak lanjut yang terkait.\n\nTindakan ini tidak dapat dibatalkan.\n\nApakah Anda yakin ingin melanjutkan?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-16 text-center">

                                <div class="text-4xl">
                                    ✈️
                                </div>

                                <p class="mt-3 font-semibold text-gray-700">
                                    Data bandara belum tersedia
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan data bandara pertama ke dalam sistem.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($bandaras->hasPages())

            <div class="border-t border-gray-200 px-6 py-4">
                {{ $bandaras->links() }}
            </div>

        @endif

    </div>

</div>

@endsection