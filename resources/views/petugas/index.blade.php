@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Inspektur
            </h1>

            <p class="mt-2 text-gray-500">
                Kelola data inspektur yang terdaftar dalam sistem SITBA.
            </p>
        </div>

        <a
            href="{{ route('petugas.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700"
        >
            + Tambah Inspektur
        </a>

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 p-5">

            <form
                method="GET"
                action="{{ route('petugas.index') }}"
                class="flex flex-col gap-3 sm:flex-row"
            >

                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Cari nama inspektur atau NIP..."
                    class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Cari
                </button>

                @if (request('keyword'))
                    <a
                        href="{{ route('petugas.index') }}"
                        class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                    >
                        Reset
                    </a>
                @endif

            </form>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Nama Inspektur
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            NIP
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($petugas as $item)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $petugas->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $item->nama_petugas }}
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-lg bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                                    {{ $item->nip }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('petugas.edit', ['petuga' => $item->id]) }}"
                                        class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('petugas.destroy', ['petuga' => $item->id]) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus data inspektur ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-16 text-center">

                                <div class="text-4xl">
                                    👷
                                </div>

                                <p class="mt-3 font-semibold text-gray-700">
                                    Data inspektur belum tersedia
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan inspektur pertama ke dalam sistem.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($petugas->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $petugas->links() }}
            </div>
        @endif

    </div>

</div>
@endsection