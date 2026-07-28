@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">

    {{-- Header halaman --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $ikon }} {{ $judul }}
        </h1>

        <p class="mt-2 text-gray-500">
            Modul {{ $judul }} pada sistem SITBA.
        </p>

    </div>


    {{-- Card Coming Soon --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-16 text-center sm:px-10">

            <div class="mb-6 text-7xl">
                {{ $ikon }}
            </div>

            <h2 class="text-2xl font-bold text-gray-800">
                Modul {{ $judul }}
            </h2>

            <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-gray-500">
                {{ $deskripsi }}
            </p>

            <div class="mx-auto mt-8 max-w-lg rounded-xl border border-blue-100 bg-blue-50 px-5 py-4">

                <p class="text-sm font-medium text-blue-700">
                    Fitur ini telah masuk dalam rencana pengembangan SITBA dan akan tersedia pada tahap berikutnya.
                </p>

            </div>

            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700"
                >
                    Kembali ke Dashboard
                </a>

                <a
                    href="{{ route('inspeksi.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Buka Data Inspeksi
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
