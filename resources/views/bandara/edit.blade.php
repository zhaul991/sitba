@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">

    <div class="mb-6">
        <a href="{{ route('bandara.index') }}"
           class="text-sm font-semibold text-blue-600 hover:text-blue-800">
            ← Kembali ke Data Bandara
        </a>

        <h1 class="mt-3 text-3xl font-bold text-gray-800">
            Edit Bandara
        </h1>

        <p class="mt-2 text-gray-500">
            Perbarui informasi bandar udara yang tersimpan di sistem SITBA.
        </p>
    </div>

    <div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:p-8">

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <p class="font-semibold text-red-700">
                    Data belum dapat diperbarui.
                </p>

                <ul class="mt-2 list-disc pl-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <form action="{{ route('bandara.update', $bandara) }}"
              method="POST"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label for="nama_bandara"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Bandara
                </label>

                <input
                    type="text"
                    id="nama_bandara"
                    name="nama_bandara"
                    value="{{ old('nama_bandara', $bandara->nama_bandara) }}"
                    required
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="kode_bandara"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Kode Bandara
                </label>

                <input
                    type="text"
                    id="kode_bandara"
                    name="kode_bandara"
                    value="{{ old('kode_bandara', $bandara->kode_bandara) }}"
                    maxlength="20"
                    required
                    class="w-full rounded-xl border-gray-300 uppercase shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Gunakan kode bandara seperti UPG, PLW, atau MJU.
                </p>
            </div>

            <div>
                <label for="lokasi"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Lokasi
                </label>

                <input
                    type="text"
                    id="lokasi"
                    name="lokasi"
                    value="{{ old('lokasi', $bandara->lokasi) }}"
                    required
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="status"
                       class="mb-2 block text-sm font-semibold text-gray-700">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Pilih status</option>

                    <option value="Aktif"
                        @selected(old('status', $bandara->status) === 'Aktif')>
                        Aktif
                    </option>

                    <option value="Tidak Aktif"
                        @selected(old('status', $bandara->status) === 'Tidak Aktif')>
                        Tidak Aktif
                    </option>
                </select>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('bandara.index') }}"
                   class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-amber-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection