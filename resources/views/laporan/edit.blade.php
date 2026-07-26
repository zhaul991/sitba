@extends('layouts.app')

@section('content')

@php
    $temuanTerpilih = collect(
        old('temuan_ids', $laporan->temuans->pluck('id')->all())
    )->map(fn ($id) => (string) $id);
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Modul Laporan
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900">
                    Edit Laporan Tindak Lanjut
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Perbarui informasi surat, dokumen PDF, dan temuan yang ditindaklanjuti.
                </p>
            </div>

            <a href="{{ route('laporan.show', $laporan) }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                ← Kembali
            </a>

        </div>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-5">
            <p class="font-semibold text-red-800">
                Terdapat data yang belum sesuai.
            </p>

            <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('laporan.update', $laporan) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
        id="form-laporan"
    >
        @csrf
        @method('PUT')

        {{-- Informasi Surat --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="text-lg font-bold text-gray-900">
                    Informasi Surat
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Perbarui data surat tindak lanjut dari bandar udara.
                </p>
            </div>

            <div class="grid gap-6 p-6 md:grid-cols-2">

                {{-- Bandara --}}
                <div class="md:col-span-2">
                    <label for="bandara_id"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Bandar Udara
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="bandara_id"
                        name="bandara_id"
                        required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Pilih Bandar Udara</option>

                        @foreach ($bandaras as $bandara)
                            <option
                                value="{{ $bandara->id }}"
                                @selected(
                                    (string) old('bandara_id', $laporan->bandara_id)
                                    === (string) $bandara->id
                                )
                            >
                                {{ $bandara->nama_bandara }}
                            </option>
                        @endforeach
                    </select>

                    @error('bandara_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Surat --}}
                <div>
                    <label for="nomor_surat"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nomor Surat
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="nomor_surat"
                        name="nomor_surat"
                        value="{{ old('nomor_surat', $laporan->nomor_surat) }}"
                        required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('nomor_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Surat --}}
                <div>
                    <label for="tanggal_surat"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Tanggal Surat
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="tanggal_surat"
                        name="tanggal_surat"
                        value="{{ old(
                            'tanggal_surat',
                            optional($laporan->tanggal_surat)->format('Y-m-d')
                        ) }}"
                        required
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('tanggal_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Perihal --}}
                <div class="md:col-span-2">
                    <label for="perihal"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Perihal
                    </label>

                    <input
                        type="text"
                        id="perihal"
                        name="perihal"
                        value="{{ old('perihal', $laporan->perihal) }}"
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('perihal')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokumen --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Dokumen PDF Saat Ini
                    </label>

                    @if ($laporan->file_surat)
                        <div class="mb-4 flex flex-col gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <p class="text-sm font-semibold text-blue-900">
                                    Dokumen laporan telah tersedia
                                </p>

                                <p class="mt-1 break-all text-xs text-blue-700">
                                    {{ basename($laporan->file_surat) }}
                                </p>
                            </div>

                            <a
                                href="{{ asset('storage/' . $laporan->file_surat) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex shrink-0 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Lihat PDF
                            </a>

                        </div>
                    @else
                        <div class="mb-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-4">
                            <p class="text-sm text-gray-500">
                                Belum ada dokumen PDF.
                            </p>
                        </div>
                    @endif

                    <label for="file_surat"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Ganti Dokumen PDF
                    </label>

                    <input
                        type="file"
                        id="file_surat"
                        name="file_surat"
                        accept="application/pdf"
                        class="block w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-700
                               file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-3
                               file:text-sm file:font-semibold file:text-gray-700
                               hover:file:bg-gray-200"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        Kosongkan apabila tidak ingin mengganti dokumen. Format PDF maksimal 5 MB.
                    </p>

                    <p id="nama-file-baru"
                       class="mt-2 hidden text-sm font-medium text-blue-700">
                    </p>

                    @error('file_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label for="keterangan"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Keterangan
                    </label>

                    <textarea
                        id="keterangan"
                        name="keterangan"
                        rows="4"
                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('keterangan', $laporan->keterangan) }}</textarea>

                    @error('keterangan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Temuan --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Temuan yang Ditindaklanjuti
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Pilih temuan yang ditutup berdasarkan laporan ini.
                    </p>
                </div>

                <span
                    id="jumlah-terpilih"
                    class="inline-flex w-fit rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700"
                >
                    0 Temuan Dipilih
                </span>

            </div>

            <div class="p-6">

                <div id="peringatan-bandara"
                     class="hidden rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                    Pilih bandar udara terlebih dahulu.
                </div>

                <div id="temuan-kosong"
                     class="hidden rounded-xl border border-dashed border-gray-300 px-6 py-10 text-center">
                    <p class="font-semibold text-gray-700">
                        Tidak ada temuan yang tersedia
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Tidak ditemukan temuan Open atau temuan lama untuk bandar udara ini.
                    </p>
                </div>

                <div id="daftar-temuan" class="space-y-4">

                    @foreach ($temuans as $temuan)

                        @php
                            $bandaraTemuan = optional($temuan->inspeksi)->bandara_id;
                            $dipilih = $temuanTerpilih->contains((string) $temuan->id);
                        @endphp

                        <label
                            class="item-temuan block cursor-pointer rounded-2xl border border-gray-200 p-5 transition hover:border-blue-300 hover:bg-blue-50/30"
                            data-bandara-id="{{ $bandaraTemuan }}"
                        >
                            <div class="flex items-start gap-4">

                                <input
                                    type="checkbox"
                                    name="temuan_ids[]"
                                    value="{{ $temuan->id }}"
                                    @checked($dipilih)
                                    class="checkbox-temuan mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >

                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                        <div>
                                            <p class="font-bold text-gray-900">
                                                {{ $temuan->nomor_temuan ?: 'Temuan #' . $temuan->id }}
                                            </p>

                                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">
                                                {{ $temuan->uraian_temuan ?: '-' }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">

                                            @if ($temuan->tingkat_risiko)
                                                <span class="inline-flex rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                    {{ $temuan->tingkat_risiko }}
                                                </span>
                                            @endif

                                            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold
                                                {{ $temuan->status === 'Close'
                                                    ? 'border-green-200 bg-green-50 text-green-700'
                                                    : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                                                {{ $temuan->status }}
                                            </span>

                                        </div>
                                    </div>

                                    <div class="mt-4 grid gap-4 text-sm sm:grid-cols-3">

                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Unsur / Elemen
                                            </p>

                                            <p class="mt-1 text-gray-800">
                                                {{ $temuan->unsur_elemen ?: '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Lokasi
                                            </p>

                                            <p class="mt-1 text-gray-800">
                                                {{ $temuan->lokasi ?: '-' }}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Tanggal Inspeksi
                                            </p>

                                            <p class="mt-1 text-gray-800">
                                                {{ optional(optional($temuan->inspeksi)->tanggal)
                                                    ? \Carbon\Carbon::parse($temuan->inspeksi->tanggal)
                                                        ->translatedFormat('d F Y')
                                                    : '-' }}
                                            </p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </label>

                    @endforeach

                </div>

                @error('temuan_ids')
                    <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>
        </div>

        {{-- Action --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('laporan.show', $laporan) }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                id="submit-button"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-blue-300"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bandaraSelect = document.getElementById('bandara_id');
        const daftarTemuan = document.getElementById('daftar-temuan');
        const itemTemuan = document.querySelectorAll('.item-temuan');
        const checkboxTemuan = document.querySelectorAll('.checkbox-temuan');
        const jumlahTerpilih = document.getElementById('jumlah-terpilih');
        const peringatanBandara = document.getElementById('peringatan-bandara');
        const temuanKosong = document.getElementById('temuan-kosong');
        const fileInput = document.getElementById('file_surat');
        const namaFileBaru = document.getElementById('nama-file-baru');
        const form = document.getElementById('form-laporan');
        const submitButton = document.getElementById('submit-button');

        function perbaruiJumlahTerpilih() {
            const total = document.querySelectorAll('.checkbox-temuan:checked').length;

            jumlahTerpilih.textContent = `${total} Temuan Dipilih`;
        }

        function filterTemuan() {
            const bandaraId = bandaraSelect.value;
            let jumlahTampil = 0;

            if (!bandaraId) {
                daftarTemuan.classList.add('hidden');
                temuanKosong.classList.add('hidden');
                peringatanBandara.classList.remove('hidden');
                return;
            }

            peringatanBandara.classList.add('hidden');

            itemTemuan.forEach(function (item) {
                const sesuaiBandara = item.dataset.bandaraId === bandaraId;

                item.classList.toggle('hidden', !sesuaiBandara);

                if (sesuaiBandara) {
                    jumlahTampil++;
                }
            });

            daftarTemuan.classList.toggle('hidden', jumlahTampil === 0);
            temuanKosong.classList.toggle('hidden', jumlahTampil !== 0);
        }

        bandaraSelect.addEventListener('change', function () {
            const bandaraId = this.value;

            checkboxTemuan.forEach(function (checkbox) {
                const item = checkbox.closest('.item-temuan');

                if (item.dataset.bandaraId !== bandaraId) {
                    checkbox.checked = false;
                }
            });

            filterTemuan();
            perbaruiJumlahTerpilih();
        });

        checkboxTemuan.forEach(function (checkbox) {
            checkbox.addEventListener('change', perbaruiJumlahTerpilih);
        });

        fileInput.addEventListener('change', function () {
            if (!this.files.length) {
                namaFileBaru.classList.add('hidden');
                namaFileBaru.textContent = '';
                return;
            }

            namaFileBaru.textContent = `File baru: ${this.files[0].name}`;
            namaFileBaru.classList.remove('hidden');
        });

        form.addEventListener('submit', function () {
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';
        });

        filterTemuan();
        perbaruiJumlahTerpilih();
    });
</script>

@endsection
