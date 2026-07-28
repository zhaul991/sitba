@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">

    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Edit Pemantauan
        </h1>

        <p class="mt-2 text-gray-500">
            Perbarui data kegiatan pemantauan bandar udara.
        </p>

    </div>


    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <form
            action="{{ route('pemantauan.update', $inspeksi) }}"
            method="POST"
            class="space-y-7 p-6 md:p-8"
        >
            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="jenis_inspeksi"
                value="Pemantauan (Monitoring)"
            >


            {{-- Bandara --}}
            <div>

                <label
                    for="bandara_id"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Bandar Udara
                </label>

                <select
                    id="bandara_id"
                    name="bandara_id"
                    required
                    class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">
                        Pilih bandar udara
                    </option>

                    @foreach ($bandaras as $bandara)

                        <option
                            value="{{ $bandara->id }}"
                            @selected(
                                old(
                                    'bandara_id',
                                    $inspeksi->bandara_id
                                ) == $bandara->id
                            )
                        >
                            {{ $bandara->nama_bandara }}

                            @if ($bandara->kode_bandara)
                                — {{ $bandara->kode_bandara }}
                            @endif
                        </option>

                    @endforeach
                </select>

                @error('bandara_id')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Tanggal --}}
            <div>

                <label
                    for="tanggal"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Tanggal Pemantauan
                </label>

                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal', optional($inspeksi->tanggal)->format('Y-m-d')) }}"
                    required
                    class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                @error('tanggal')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Jenis --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Jenis Kegiatan
                </label>

                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">

                    <p class="text-sm font-semibold text-blue-700">
                        👁️ Pemantauan (Monitoring)
                    </p>

                    <p class="mt-1 text-xs text-blue-600">
                        Jenis kegiatan ditentukan otomatis oleh sistem.
                    </p>

                </div>

            </div>


            {{-- Inspektur --}}
            <div>

                <label class="mb-3 block text-sm font-semibold text-gray-700">
                    Inspektur
                </label>

                @php
                    $petugasTerpilih = old(
                        'petugas',
                        $inspeksi->petugas->pluck('id')->all()
                    );
                @endphp

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($petugas as $item)

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50">

                            <input
                                type="checkbox"
                                name="petugas[]"
                                value="{{ $item->id }}"
                                @checked(in_array($item->id, $petugasTerpilih))
                                class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >

                            <span>

                                <span class="block text-sm font-semibold text-gray-800">
                                    {{ $item->nama_petugas }}
                                </span>

                                @if (!empty($item->nip))
                                    <span class="mt-1 block text-xs text-gray-500">
                                        NIP {{ $item->nip }}
                                    </span>
                                @endif

                            </span>

                        </label>

                    @endforeach

                </div>

                @error('petugas')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                @error('petugas.*')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Keterangan --}}
            <div>

                <label
                    for="keterangan"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Keterangan
                </label>

                <textarea
                    id="keterangan"
                    name="keterangan"
                    rows="5"
                    placeholder="Masukkan keterangan kegiatan pemantauan..."
                    class="w-full rounded-xl border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >{{ old('keterangan', $inspeksi->keterangan) }}</textarea>

                @error('keterangan')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Tombol --}}
            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('pemantauan.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
