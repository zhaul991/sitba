@extends('layouts.app')

@section('title', 'SITBA')

@section('content')

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-4xl w-full rounded-3xl border border-slate-200 bg-white shadow-sm p-10 md:p-14 text-center">

        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-600 text-4xl shadow">
            ✈️
        </div>


        <h1 class="mt-8 text-4xl md:text-5xl font-black text-slate-800">
            SITBA
        </h1>


        <p class="mt-3 text-lg font-semibold text-blue-600">
            Sistem Informasi Temuan Bandar Udara
        </p>


        <p class="mx-auto mt-5 max-w-2xl text-slate-500 leading-relaxed">
            Platform digital untuk pencatatan inspeksi, monitoring temuan,
            tindak lanjut, serta histori aktivitas keselamatan operasional
            bandar udara secara terintegrasi.
        </p>


        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">

            @auth

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Masuk Dashboard
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Masuk Sistem
                </a>

            @endauth


        </div>


        <div class="mt-10 grid gap-4 md:grid-cols-3">

            <div class="rounded-2xl bg-slate-50 p-5">
                <div class="text-2xl">🏢</div>
                <p class="mt-2 font-bold text-slate-700">
                    Data Bandara
                </p>
            </div>


            <div class="rounded-2xl bg-slate-50 p-5">
                <div class="text-2xl">⚠️</div>
                <p class="mt-2 font-bold text-slate-700">
                    Monitoring Temuan
                </p>
            </div>


            <div class="rounded-2xl bg-slate-50 p-5">
                <div class="text-2xl">📊</div>
                <p class="mt-2 font-bold text-slate-700">
                    Dashboard Analitik
                </p>
            </div>

        </div>

    </div>

</div>

@endsection
