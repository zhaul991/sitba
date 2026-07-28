@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Inspeksi
            </h1>

            <p class="mt-2 text-gray-500">
                Kelola seluruh kegiatan inspeksi bandar udara dalam sistem SITBA.
            </p>
        </div>

        <a href="{{ route('inspeksi.create') }}"
           class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700">
            + Tambah Inspeksi
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <x-filter-panel
        title="Filter Data Inspeksi"
        description="Cari dan saring kegiatan inspeksi berdasarkan bandara, tahun, atau inspektur."
    >
        <form
            method="GET"
            action="{{ route('inspeksi.index') }}"
            class="grid grid-cols-1 gap-4 lg:grid-cols-12"
        >
            <div class="lg:col-span-4">
                <label
                    for="keyword"
                    class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500"
                >
                    Pencarian
                </label>

                <input
                    id="keyword"
                    type="text"
                    name="keyword"
                    value="{{ request('keyword', request('q')) }}"
                    placeholder="Bandara, inspektur, NIP, atau jenis inspeksi..."
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div class="lg:col-span-3">
                <label
                    for="bandara_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500"
                >
                    Bandara
                </label>

                <select
                    id="bandara_id"
                    name="bandara_id"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Semua Bandara</option>

                    @foreach ($daftarBandara as $bandara)
                        <option
                            value="{{ $bandara->id }}"
                            @selected(
                                (string) request('bandara_id')
                                === (string) $bandara->id
                            )
                        >
                            {{ $bandara->kode_bandara }}
                            — {{ $bandara->nama_bandara }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2">
                <label
                    for="tahun"
                    class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500"
                >
                    Tahun
                </label>

                <select
                    id="tahun"
                    name="tahun"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Semua Tahun</option>

                    @foreach ($daftarTahun as $tahun)
                        <option
                            value="{{ $tahun }}"
                            @selected(
                                (string) request('tahun')
                                === (string) $tahun
                            )
                        >
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3">
                <label
                    for="petugas_id"
                    class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500"
                >
                    Inspektur
                </label>

                <select
                    id="petugas_id"
                    name="petugas_id"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Semua Inspektur</option>

                    @foreach ($daftarPetugas as $inspektur)
                        <option
                            value="{{ $inspektur->id }}"
                            @selected(
                                (string) request('petugas_id')
                                === (string) $inspektur->id
                            )
                        >
                            {{ $inspektur->nama_petugas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div
                class="flex flex-col gap-3 sm:flex-row lg:col-span-12 lg:justify-end"
            >
                @if (
                    request()->filled('keyword')
                    || request()->filled('q')
                    || request()->filled('bandara_id')
                    || request()->filled('tahun')
                    || request()->filled('petugas_id')
                )
                    <a
                        href="{{ route('inspeksi.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        Reset Filter
                    </a>
                @endif

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Terapkan Filter
                </button>
            </div>
        </form>
    </x-filter-panel>

    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Bandara
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Inspektur
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Jenis Inspeksi
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($inspeksis as $item)

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $inspeksis->firstItem() + $loop->index }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $item->tanggal->format('d-m-Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $item->bandara->nama_bandara }}
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $item->bandara->kode_bandara }}
                                </div>
                            </td>

                            <td class="px-6 py-4">

                                @if ($item->petugas->count())

                                    <div class="mb-2 text-sm font-bold text-gray-700">
                                        👥 {{ $item->petugas->count() }} Inspektur
                                    </div>

                                    <div class="space-y-1">

                                        @foreach ($item->petugas->take(3) as $inspektur)

                                            <div class="text-sm text-gray-600">
                                                {{ $inspektur->nama_petugas }}
                                            </div>

                                        @endforeach

                                    </div>

                                    @if ($item->petugas->count() > 3)

                                        <button
                                            type="button"
                                            onclick="bukaModalInspektur({{ $item->id }})"
                                            class="mt-2 text-xs font-semibold text-blue-600 hover:text-blue-800"
                                        >
                                            +{{ $item->petugas->count() - 3 }} lainnya
                                        </button>

                                    @endif

                                @else

                                    <span class="text-sm text-gray-400">
                                        Belum ada inspektur
                                    </span>

                                @endif

                            </td>

                            <td class="max-w-xs px-6 py-4 text-sm text-gray-600">
                                {{ $item->jenis_inspeksi ?: '-' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('inspeksi.show', $item) }}"
                                       class="rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                                        Detail
                                    </a>

                                    <a href="{{ route('inspeksi.edit', $item) }}"
                                       class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('inspeksi.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data inspeksi ini?')">

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
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="text-4xl">
                                    🔍
                                </div>

                                <p class="mt-3 font-semibold text-gray-700">
                                    Data inspeksi belum tersedia
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan kegiatan inspeksi pertama ke dalam sistem.
                                </p>

                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>


            @foreach ($inspeksis as $item)

                @if ($item->petugas->count() > 3)

                    <div
                        id="modal-inspektur-{{ $item->id }}"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4"
                    >

                        <div
                            class="flex h-[80vh] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-xl"
                        >

                            <div class="mb-5 flex shrink-0 items-center justify-between">

                                <div>
                                    <h2 class="flex items-center gap-2 text-lg font-bold text-gray-800">
                                        <span>
                                            👥
                                        </span>

                                        Tim Inspeksi
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $item->petugas->count() }} personel terlibat dalam kegiatan inspeksi ini.
                                    </p>
                                </div>


                                <button
                                    type="button"
                                    onclick="tutupModalInspektur({{ $item->id }})"
                                    class="rounded-full p-2 text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                >
                                    &times;
                                </button>

                            </div>


                            <div class="mt-4 min-h-0 flex-1 space-y-3 overflow-y-auto pr-2">

                                @foreach ($item->petugas as $index => $inspektur)

                                    <div
                                        class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
                                    >

                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700"
                                        >
                                            {{ strtoupper(substr($inspektur->nama_petugas, 0, 2)) }}
                                        </div>


                                        <div>

                                            <div class="font-semibold text-gray-800">
                                                {{ $index + 1 }}. {{ $inspektur->nama_petugas }}
                                            </div>

                                            <div class="mt-1 text-sm text-gray-500">
                                                NIP: {{ $inspektur->nip }}
                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach
        </div>

        @if ($inspeksis->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $inspeksis->links() }}
            </div>
        @endif

    </div>

</div>
<script>

function bukaModalInspektur(id)
{
    const modal = document.getElementById(
        'modal-inspektur-' + id
    );

    if (!modal) {
        return;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function tutupModalInspektur(id)
{
    const modal = document.getElementById(
        'modal-inspektur-' + id
    );

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


document.addEventListener('click', function(event) {

    if (
        event.target.classList.contains('fixed')
    ) {

        event.target.classList.add('hidden');
        event.target.classList.remove('flex');

    }

});


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        document.querySelectorAll('[id^="modal-inspektur-"]')
            .forEach(modal => {

                modal.classList.add('hidden');
                modal.classList.remove('flex');

            });

    }

});

</script>


@endsection
