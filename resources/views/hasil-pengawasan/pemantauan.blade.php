@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $judulHalaman }}
            </h1>

            <p class="mt-2 text-gray-500">
                {{ $deskripsiHalaman }}
            </p>
        </div>

        
<div class="flex items-center gap-3">

    <button
        type="button"
        disabled
        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2
               text-sm font-semibold text-white opacity-60 cursor-not-allowed">

        📄 Export PDF
        <span class="ml-2 rounded-full bg-white/20 px-2 py-0.5 text-xs">
            Segera Hadir
        </span>
    </button>

    <button
        type="button"
        disabled
        class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2
               text-sm font-semibold text-white opacity-60 cursor-not-allowed">

        📊 Export Excel
        <span class="ml-2 rounded-full bg-white/20 px-2 py-0.5 text-xs">
            Segera Hadir
        </span>
    </button>

</div>

    </div>


    {{-- Ringkasan Temuan --}}
    <div class="mb-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Temuan</p>
            <p class="mt-3 text-3xl font-bold text-slate-800">
                {{ number_format($totalTemuan) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-blue-600">
                Berdasarkan filter aktif
            </p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-red-600">Open</p>
            <p class="mt-3 text-3xl font-bold text-red-700">
                {{ number_format($totalOpen) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-red-600">
                Belum ditindaklanjuti
            </p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-red-600">Unsatisfactory</p>
            <p class="mt-3 text-3xl font-bold text-red-700">
                {{ number_format($totalUnsatisfactory) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-red-600">
                Tindak lanjut belum memadai
            </p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-emerald-600">Satisfactory</p>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($totalSatisfactory) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-emerald-600">
                Tindak lanjut memadai
            </p>
        </div>

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-emerald-600">Close</p>
            <p class="mt-3 text-3xl font-bold text-emerald-700">
                {{ number_format($totalClose) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-emerald-600">
                Temuan telah ditutup
            </p>
        </div>

    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

        <div class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-green-600">Risiko Rendah</p>
            <p class="mt-3 text-3xl font-bold text-green-700">
                {{ number_format($totalRisikoRendah) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-green-600">
                Prioritas normal
            </p>
        </div>

        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-yellow-700">Risiko Sedang</p>
            <p class="mt-3 text-3xl font-bold text-yellow-800">
                {{ number_format($totalRisikoSedang) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-yellow-700">
                Perlu pemantauan
            </p>
        </div>

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
            <p class="text-sm font-medium text-red-600">Risiko Tinggi</p>
            <p class="mt-3 text-3xl font-bold text-red-700">
                {{ number_format($totalRisikoTinggi) }}
            </p>
            <p class="mt-4 text-xs font-semibold text-red-600">
                Perlu perhatian segera
            </p>
        </div>

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
                action="{{ route('hasil-pengawasan.pemantauan') }}"
                class="grid gap-3 md:grid-cols-2 xl:grid-cols-6"
            >
                {{-- Keyword --}}
                <div class="xl:col-span-2">
                    <label
                        for="keyword"
                        class="mb-1.5 block text-xs font-semibold
                               uppercase tracking-wide text-slate-500"
                    >
                        Pencarian
                    </label>

                    <input
                        id="keyword"
                        type="text"
                        name="keyword"
                        value="{{ request('keyword', request('q')) }}"
                        placeholder="Nomor, bandara, unsur, atau lokasi..."
                        class="w-full rounded-xl border-gray-300
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >
                </div>

                {{-- Bandara --}}
                <div>
                    <label
                        for="bandara_id"
                        class="mb-1.5 block text-xs font-semibold
                               uppercase tracking-wide text-slate-500"
                    >
                        Bandara
                    </label>

                    <select
                        id="bandara_id"
                        name="bandara_id"
                        class="w-full rounded-xl border-gray-300
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >
                        <option value="">
                            Semua Bandara
                        </option>

                        @foreach ($daftarBandara as $bandara)
                            <option
                                value="{{ $bandara->id }}"
                                @selected(
                                    (string) request('bandara_id')
                                    === (string) $bandara->id
                                )
                            >
                                {{ $bandara->nama_bandara }}
                                @if ($bandara->kode_bandara)
                                    ({{ $bandara->kode_bandara }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun --}}
                <div>
                    <label
                        for="tahun"
                        class="mb-1.5 block text-xs font-semibold
                               uppercase tracking-wide text-slate-500"
                    >
                        Tahun Inspeksi
                    </label>

                    <select
                        id="tahun"
                        name="tahun"
                        class="w-full rounded-xl border-gray-300
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >
                        <option value="">
                            Semua Tahun
                        </option>

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

                {{-- Risiko --}}
                <div>
                    <label
                        for="tingkat_risiko"
                        class="mb-1.5 block text-xs font-semibold
                               uppercase tracking-wide text-slate-500"
                    >
                        Risiko
                    </label>

                    <select
                        id="tingkat_risiko"
                        name="tingkat_risiko"
                        class="w-full rounded-xl border-gray-300
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >
                        
                        <option value="">Semua Risiko</option>

                        @foreach (config('sitba.risiko') as $risiko)
                            <option
                                value="{{ $risiko }}"
                                @selected(request('tingkat_risiko') === $risiko)
                            >
                                {{ $risiko }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label
                        for="status"
                        class="mb-1.5 block text-xs font-semibold
                               uppercase tracking-wide text-slate-500"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-gray-300
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >
                        
                        <option value="">Semua Status</option>

                        @foreach (config('sitba.status') as $status)
                            <option
                                value="{{ $status }}"
                                @selected(request('status') === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Tombol --}}
                <div
                    class="flex items-end gap-2
                           md:col-span-2 xl:col-span-6"
                >
                    <button
                        type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-3
                               text-sm font-semibold text-white
                               transition hover:bg-blue-700"
                    >
                        Terapkan Filter
                    </button>

                    @if (
                        request()->hasAny([
                            'q',
                            'keyword',
                            'bandara_id',
                            'tahun',
                            'tingkat_risiko',
                            'status',
                        ])
                    )
                        <a
                            href="{{ route('hasil-pengawasan.pemantauan') }}"
                            class="rounded-xl border border-gray-300
                                   px-5 py-3 text-center text-sm
                                   font-semibold text-gray-600
                                   transition hover:bg-gray-50"
                        >
                            Reset
                        </a>
                    @endif
                </div>
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
                            Nomor Temuan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Inspeksi
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Unsur / Lokasi
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Risiko
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
                    @forelse ($temuans as $temuan)

                        @php
                            $risikoClass = match ($temuan->tingkat_risiko) {
                                'Rendah' => 'bg-green-50 text-green-700',
                                'Sedang' => 'bg-yellow-50 text-yellow-700',
                                'Tinggi' => 'bg-red-50 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };

                            $statusClass = match ($temuan->status) {
                                'Open' => 'bg-red-50 text-red-700',
                                'Unsatisfactory' => 'bg-red-50 text-red-700',
                                'Satisfactory' => 'bg-green-50 text-green-700',
                                'Close' => 'bg-green-50 text-green-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $temuans->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $temuan->nomor_temuan }}
                                </div>

                                <div class="mt-1 max-w-xs text-sm text-gray-500">
                                    {{ \Illuminate\Support\Str::limit($temuan->uraian_temuan, 70) }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $temuan->inspeksi?->bandara?->nama_bandara ?? '-' }}
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $temuan->inspeksi?->tanggal?->format('d-m-Y') ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $temuan->unsur_elemen }}
                                </div>

                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $temuan->lokasi }}
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-lg px-3 py-1 text-xs font-semibold {{ $risikoClass }}">
                                    {{ $temuan->tingkat_risiko }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-lg px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $temuan->status }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('temuan.show', $temuan) }}"
                                       class="rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                                        Detail
                                    </a>

                                    <a href="{{ route('temuan.edit', $temuan) }}"
                                       class="rounded-lg bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('temuan.destroy', $temuan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus temuan ini?')">

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
                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="text-4xl">
                                    📋
                                </div>

                                <p class="mt-3 font-semibold text-gray-700">
                                    Data temuan belum tersedia
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan temuan hasil inspeksi pertama.
                                </p>

                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($temuans->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $temuans->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
