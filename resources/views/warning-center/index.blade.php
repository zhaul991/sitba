@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">


    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            🚨 Warning Center
        </h1>

        <p class="mt-2 text-gray-500">
            Monitoring temuan yang membutuhkan perhatian dan pengendalian risiko.
        </p>

    </div>



    {{-- Warning Summary --}}
    <div class="grid gap-4 md:grid-cols-3 mb-8">


        <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

            <p class="text-sm font-semibold text-red-700">
                🚨 Overdue
            </p>

            <p class="mt-3 text-3xl font-black text-red-800">
                {{ $temuanOverdue->count() }}
            </p>

            <a href="{{ route('temuan.index', ['filter' => 'overdue']) }}"
               class="mt-4 inline-flex text-sm font-bold text-red-700 hover:underline">
                Lihat temuan →
            </a>

        </div>



        <div class="rounded-2xl border border-orange-200 bg-orange-50 p-5">

            <p class="text-sm font-semibold text-orange-700">
                ⏳ Menahun
            </p>

            <p class="mt-3 text-3xl font-black text-orange-800">
                {{ $temuanMenahun->count() }}
            </p>

            <a href="{{ route('temuan.index', ['filter' => 'menahun']) }}"
               class="mt-4 inline-flex text-sm font-bold text-orange-700 hover:underline">
                Lihat temuan →
            </a>

        </div>



        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">

            <p class="text-sm font-semibold text-yellow-700">
                ⚠️ Risiko Tinggi
            </p>

            <p class="mt-3 text-3xl font-black text-yellow-800">
                {{ $risikoTinggi->count() }}
            </p>

            <a href="{{ route('temuan.index', ['tingkat_risiko' => 'Tinggi']) }}"
               class="mt-4 inline-flex text-sm font-bold text-yellow-700 hover:underline">
                Lihat temuan →
            </a>

        </div>


    </div>



    {{-- Risk Profile --}}
    <div class="mb-8 rounded-2xl border bg-white p-6 shadow-sm">


        <h2 class="text-lg font-bold text-gray-800">
            📊 Profil Risiko Temuan
        </h2>


        <p class="mt-1 text-sm text-gray-500">
            Distribusi tingkat risiko seluruh temuan dalam SITBA.
        </p>



        <div class="mt-5 grid gap-4 md:grid-cols-3">


            <div class="rounded-xl bg-red-50 p-5">

                <p class="font-semibold text-red-700">
                    🔴 Risiko Tinggi
                </p>

                <p class="mt-2 text-3xl font-black text-red-800">
                    {{ $jumlahRisikoTinggi }}
                </p>

                <a href="{{ route('temuan.index', ['tingkat_risiko' => 'Tinggi']) }}"
                   class="mt-3 inline-flex text-sm font-bold text-red-700 hover:underline">
                    Lihat →
                </a>

            </div>



            <div class="rounded-xl bg-yellow-50 p-5">

                <p class="font-semibold text-yellow-700">
                    🟡 Risiko Sedang
                </p>

                <p class="mt-2 text-3xl font-black text-yellow-800">
                    {{ $jumlahRisikoSedang }}
                </p>

                <a href="{{ route('temuan.index', ['tingkat_risiko' => 'Sedang']) }}"
                   class="mt-3 inline-flex text-sm font-bold text-yellow-700 hover:underline">
                    Lihat →
                </a>

            </div>



            <div class="rounded-xl bg-green-50 p-5">

                <p class="font-semibold text-green-700">
                    🟢 Risiko Rendah
                </p>

                <p class="mt-2 text-3xl font-black text-green-800">
                    {{ $jumlahRisikoRendah }}
                </p>

                <a href="{{ route('temuan.index', ['tingkat_risiko' => 'Rendah']) }}"
                   class="mt-3 inline-flex text-sm font-bold text-green-700 hover:underline">
                    Lihat →
                </a>

            </div>


        </div>


    </div>




    {{-- Daftar perhatian --}}
    <div class="rounded-2xl border bg-white shadow-sm overflow-hidden">


        <div class="border-b px-6 py-4">

            <h2 class="font-bold text-gray-800">
                📋 Daftar Temuan Perhatian
            </h2>

        </div>



        <div class="divide-y">


            @forelse($temuanOverdue->merge($temuanMenahun)->unique('id') as $temuan)


                <a href="{{ route('temuan.show', $temuan) }}"
                   class="block px-6 py-4 hover:bg-gray-50">


                    <p class="font-bold text-gray-800">
                        {{ $temuan->nomor_temuan }}
                    </p>


                    <p class="text-sm text-gray-500">
                        {{ $temuan->inspeksi?->bandara?->nama_bandara ?? '-' }}
                    </p>


                    <div class="mt-3 flex flex-wrap gap-2">


                        @if($temuan->due_date && \Carbon\Carbon::parse($temuan->due_date)->isPast())

                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                🚨 OVERDUE
                            </span>

                        @endif



                        @if($temuan->status === 'Open' && $temuan->created_at->lt(now()->subYear()))

                            <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-bold text-orange-700">
                                ⏳ MENAHUN
                            </span>

                        @endif


                    </div>


                    @if($temuan->due_date && \Carbon\Carbon::parse($temuan->due_date)->isPast())

                        <p class="mt-2 text-xs text-red-600">
                            Melewati batas waktu penyelesaian.
                        </p>

                    @elseif($temuan->created_at->lt(now()->subYear()))

                        <p class="mt-2 text-xs text-orange-600">
                            Belum selesai lebih dari 1 tahun.
                        </p>

                    @endif


                    @php
                        $umurTemuan = $temuan->created_at
                            ? $temuan->created_at->diff(now())
                            : null;
                    @endphp


                    @if($umurTemuan)

                        <p class="mt-3 text-xs font-semibold text-gray-600">
                            ⏳ Umur Temuan:
                            {{ $umurTemuan->y }} tahun
                            @if($umurTemuan->m > 0)
                                {{ $umurTemuan->m }} bulan
                            @endif
                        </p>

                    @endif


                </a>


            @empty


                <div class="px-6 py-10 text-center text-gray-500">

                    ✅ Tidak ada temuan yang membutuhkan perhatian.

                </div>


            @endforelse


        </div>


    </div>



</div>

@endsection
