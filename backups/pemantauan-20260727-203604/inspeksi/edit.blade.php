@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Edit Inspeksi
        </h1>

        <p class="mt-2 text-gray-500">
            Perbarui data kegiatan inspeksi bandar udara.
        </p>
    </div>

    <div class="max-w-4xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold">
                    Data inspeksi belum dapat diperbarui.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inspeksi.update', $inspeksi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label for="bandara_id"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Bandara
                    </label>

                    <select
                        id="bandara_id"
                        name="bandara_id"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">
                            Pilih bandara
                        </option>

                        @foreach ($bandaras as $bandara)
                            <option
                                value="{{ $bandara->id }}"
                                @selected(old('bandara_id', $inspeksi->bandara_id) == $bandara->id)
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

                <div>
                    <label for="tanggal"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Tanggal Inspeksi
                    </label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{ old('tanggal', $inspeksi->tanggal->format('Y-m-d')) }}"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    @error('tanggal')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <div class="mb-3 flex items-center justify-between">
                        <label class="block text-sm font-semibold text-gray-700">
                            Inspektur
                        </label>

                        <span class="text-xs text-gray-500">
                            Pilih minimal satu inspektur
                        </span>
                    </div>

                    @php
                        $petugasTerpilih = old(
                            'petugas',
                            $inspeksi->petugas->pluck('id')->toArray()
                        );
                    @endphp

                    <div class="grid gap-3 sm:grid-cols-2">

                        @foreach ($petugas as $inspektur)
                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
                            >
                                <input
                                    type="checkbox"
                                    name="petugas[]"
                                    value="{{ $inspektur->id }}"
                                    class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    @checked(in_array($inspektur->id, $petugasTerpilih))
                                >

                                <span>
                                    <span class="block font-semibold text-gray-800">
                                        {{ $inspektur->nama_petugas }}
                                    </span>

                                    <span class="mt-1 block text-sm text-gray-500">
                                        NIP: {{ $inspektur->nip }}
                                    </span>
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

                <div>
                <div>
                    <label
                        for="jenis_inspeksi"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Jenis Inspeksi
                    </label>

                    <select
                        id="jenis_inspeksi"
                        name="jenis_inspeksi"
                        class="w-full rounded-xl border-gray-300 shadow-sm
                               focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                        <option value="">
                            Pilih jenis inspeksi
                        </option>

                        <option value="Inspeksi Keselamatan"
                            @selected(old('jenis_inspeksi', $inspeksi->jenis_inspeksi) == 'Inspeksi Keselamatan')
                        >
                            Inspeksi Keselamatan
                        </option>

                        <option value="Inspeksi Angkutan Lebaran"
                            @selected(old('jenis_inspeksi', $inspeksi->jenis_inspeksi) == 'Inspeksi Angkutan Lebaran')
                        >
                            Inspeksi Angkutan Lebaran
                        </option>

                        <option value="Inspeksi Angkutan Liburan"
                            @selected(old('jenis_inspeksi', $inspeksi->jenis_inspeksi) == 'Inspeksi Angkutan Liburan')
                        >
                            Inspeksi Angkutan Liburan
                        </option>

                        <option value="Inspeksi Nataru"
                            @selected(old('jenis_inspeksi', $inspeksi->jenis_inspeksi) == 'Inspeksi Nataru')
                        >
                            Inspeksi Nataru
                        </option>

                        <option value="Lainnya"
                            @selected(old('jenis_inspeksi', $inspeksi->jenis_inspeksi) == 'Lainnya')
                        >
                            Lainnya
                        </option>

                    </select>

                    @error('jenis_inspeksi')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('inspeksi.index') }}"
                   class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan Perubahan
                </button>

            </div>
        </form>

    </div>

</div>
@endsection
