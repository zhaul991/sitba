@extends('layouts.app')

@section('content')

<div class="p-6 md:p-8">


    <div class="mb-8 flex items-center justify-between">


        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                📁 Draft Center
            </h1>


            <p class="mt-2 text-gray-500">
                Pusat dokumen template inspeksi bandar udara.
                Gunakan dokumen ini sebagai acuan pelaksanaan kegiatan pengawasan.
            </p>

        </div>



        @if(auth()->user()->isAdmin())

        <a href="{{ route('draft.create') }}"
           class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow">

            + Tambah Draft

        </a>

        @endif


    </div>




    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">



        <div class="border-b border-gray-200 px-6 py-5">

            <h2 class="text-lg font-bold text-gray-800">
                Daftar Dokumen Draft Inspeksi
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Template dokumen yang tersedia untuk mendukung kegiatan inspeksi.
            </p>

        </div>




        <table class="w-full">


            <thead class="bg-gray-50">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Nama Draft
                    </th>


                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Aksi
                    </th>

                </tr>


            </thead>



            <tbody class="divide-y">



            @forelse($drafts as $draft)


                <tr class="transition hover:bg-gray-50">


                    <td class="px-6 py-5 font-semibold text-gray-800">

                        {{ $draft->nama_draft }}

                    </td>




                    <td class="px-6 py-5 text-right">


                        <a href="{{ route('draft.download', $draft) }}"
                           class="inline-flex items-center rounded-lg bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">

                            ⬇ Download

                        </a>




                        @if(auth()->user()->isAdmin())


                        <form action="{{ route('draft.destroy', $draft) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')


                            <button
                                class="ml-2 inline-flex items-center rounded-lg bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                                onclick="return confirm('Hapus draft ini?')">

                                🗑 Hapus

                            </button>


                        </form>


                        @endif



                    </td>


                </tr>



            @empty



                <tr>

                    <td colspan="2"
                        class="px-6 py-12 text-center text-gray-500">


                        <div class="text-3xl">
                            📂
                        </div>


                        <p class="mt-3 font-medium">
                            Belum terdapat dokumen draft.
                        </p>


                        <p class="mt-1 text-sm">
                            Silakan tambahkan template dokumen inspeksi.
                        </p>


                    </td>

                </tr>



            @endforelse



            </tbody>



        </table>



    </div>



</div>


@endsection
