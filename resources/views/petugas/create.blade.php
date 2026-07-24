@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Inspektur
        </h1>

        <p class="mt-2 text-gray-500">
            Tambahkan data inspektur baru ke dalam sistem SITBA.
        </p>
    </div>

    <div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold">
                    Data belum dapat disimpan.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.store') }}" method="POST">
            @csrf

            <div class="space-y-6">

                <div>
                    <label for="nama_petugas"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Inspektur
                    </label>

                    <input
                        type="text"
                        id="nama_petugas"
                        name="nama_petugas"
                        value="{{ old('nama_petugas') }}"
                        placeholder="Masukkan nama lengkap inspektur"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    @error('nama_petugas')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="nip"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        NIP
                    </label>

                    <input
                        type="text"
                        id="nip"
                        name="nip"
                        value="{{ old('nip') }}"
                        placeholder="Masukkan NIP inspektur"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    @error('nip')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('petugas.index') }}"
                   class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan Inspektur
                </button>

            </div>
        </form>

    </div>

</div>
@endsection