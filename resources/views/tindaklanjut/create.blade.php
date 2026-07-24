@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Tindak Lanjut
        </h1>

        <p class="mt-2 text-gray-500">
            Catat rencana perbaikan dan penanggung jawab temuan.
        </p>
    </div>

    <div class="max-w-4xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-5">
            <p class="text-sm font-semibold text-blue-700">
                Temuan
            </p>

            <p class="mt-1 text-lg font-bold text-blue-900">
                {{ $temuan->nomor_temuan }}
            </p>

            <p class="mt-2 text-sm text-blue-700">
                {{ $temuan->inspeksi?->bandara?->nama_bandara ?? '-' }}
                — {{ $temuan->uraian_temuan }}
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold">
                    Tindak lanjut belum dapat disimpan.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tindaklanjut.store') }}" method="POST">
            @csrf

            <input
                type="hidden"
                name="temuan_id"
                value="{{ $temuan->id }}"
            >

            <div class="space-y-6">

                <div>
                    <label
                        for="rencana_perbaikan"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Rencana Perbaikan
                    </label>

                    <textarea
                        id="rencana_perbaikan"
                        name="rencana_perbaikan"
                        rows="6"
                        placeholder="Jelaskan rencana tindakan atau perbaikan..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >{{ old('rencana_perbaikan') }}</textarea>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label
                            for="pic"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            PIC / Penanggung Jawab
                        </label>

                        <input
                            type="text"
                            id="pic"
                            name="pic"
                            value="{{ old('pic') }}"
                            placeholder="Nama atau unit penanggung jawab"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <div>
                        <label
                            for="deadline"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Batas Waktu
                        </label>

                        <input
                            type="date"
                            id="deadline"
                            name="deadline"
                            value="{{ old('deadline') }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>

                </div>

                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Status Tindak Lanjut
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">Pilih status</option>

                        <option
                            value="Open"
                            @selected(old('status', 'Open') === 'Open')
                        >
                            Open
                        </option>

                        <option
                            value="Dalam Tindak Lanjut"
                            @selected(old('status') === 'Dalam Tindak Lanjut')
                        >
                            Dalam Tindak Lanjut
                        </option>

                        <option
                            value="Selesai"
                            @selected(old('status') === 'Selesai')
                        >
                            Selesai
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        for="catatan"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Catatan
                    </label>

                    <textarea
                        id="catatan"
                        name="catatan"
                        rows="4"
                        placeholder="Catatan tambahan bila diperlukan..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('catatan') }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('temuan.show', $temuan) }}"
                    class="rounded-xl border border-gray-300 px-5 py-3 text-center text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                >
                    Simpan Tindak Lanjut
                </button>

            </div>
        </form>

    </div>

</div>
@endsection
