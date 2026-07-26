@extends('layouts.app')

@section('title', 'Tambah Bandara')

@section('content')

<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-800">
            Tambah Bandara
        </h1>

        <p class="mt-2 text-slate-500">
            Tambahkan data bandar udara baru ke dalam sistem SITBA.
        </p>
    </div>


    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">
            <h2 class="text-lg font-black text-slate-800">
                Informasi Bandara
            </h2>
        </div>


        <div class="p-6">

            <form action="{{ route('bandara.store') }}" method="POST">

                @csrf


                <div class="mb-5">

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Nama Bandara
                    </label>

                    <input
                        type="text"
                        name="nama_bandara"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3 text-sm
                               focus:border-blue-500 focus:ring-blue-500"
                        required>

                </div>


                <div class="mb-5">

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Kode Bandara
                    </label>

                    <input
                        type="text"
                        name="kode_bandara"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3 text-sm
                               focus:border-blue-500 focus:ring-blue-500"
                        required>

                </div>


                <div class="mb-5">

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Lokasi
                    </label>

                    <input
                        type="text"
                        name="lokasi"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3 text-sm
                               focus:border-blue-500 focus:ring-blue-500"
                        required>

                </div>


                <div class="mb-6">

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300
                               px-4 py-3 text-sm
                               focus:border-blue-500 focus:ring-blue-500">

                        <option value="Aktif">
                            Aktif
                        </option>

                        <option value="Non Aktif">
                            Non Aktif
                        </option>

                    </select>

                </div>


                <div class="flex gap-3">

                    <button
                        class="rounded-xl bg-blue-600 px-5 py-3
                               text-sm font-bold text-white
                               shadow-sm transition hover:bg-blue-700">

                        💾 Simpan

                    </button>


                    <a
                        href="{{ route('bandara.index') }}"
                        class="rounded-xl bg-slate-100 px-5 py-3
                               text-sm font-bold text-slate-700
                               transition hover:bg-slate-200">

                        ← Kembali

                    </a>

                </div>


            </form>

        </div>

    </div>

</div>

@endsection
