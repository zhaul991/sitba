@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Draft
        </h1>

        <p class="mt-2 text-gray-500">
            Upload template dokumen inspeksi bandar udara.
        </p>

    </div>


    <div class="max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">


        <form action="{{ route('draft.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf


            <div class="mb-5">

                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Draft
                </label>

                <input
                    type="text"
                    name="nama_draft"
                    value="{{ old('nama_draft') }}"
                    placeholder="Contoh: Draft Berita Acara Inspeksi"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required
                >

            </div>



            <div class="mb-6">

                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    File Draft
                </label>

                <input
                    type="file"
                    name="file"
                    accept=".doc,.docx"
                    class="w-full rounded-xl border border-gray-300 p-3"
                    required
                >

                <p class="mt-2 text-xs text-gray-500">
                    Format yang diperbolehkan: Word (.doc/.docx), maksimal 10 MB.
                </p>

            </div>



            <div class="flex gap-3">

                <a href="{{ route('draft.index') }}"
                   class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    Kembali
                </a>


                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    Simpan Draft
                </button>

            </div>


        </form>


    </div>

</div>

@endsection
