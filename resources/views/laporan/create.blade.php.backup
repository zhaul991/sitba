@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
                    Modul Laporan
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900">
                    Tambah Laporan Tindak Lanjut
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Input surat tindak lanjut dari bandara dan pilih temuan yang ditindaklanjuti.
                </p>
            </div>

            <a href="{{ route('laporan.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </div>


    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="font-medium text-red-800">
                        Terdapat data yang belum sesuai.
                    </div>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('laporan.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                @csrf

                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">
                            Informasi Surat
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Lengkapi data surat tindak lanjut yang diterima dari bandara.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label
                                for="bandara_id"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Bandara
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="bandara_id"
                                name="bandara_id"
                                required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Pilih Bandara</option>

                                @foreach ($bandaras as $bandara)
                                    <option
                                        value="{{ $bandara->id }}"
                                        @selected(old('bandara_id') == $bandara->id)
                                    >
                                        {{ $bandara->nama_bandara }}
                                    </option>
                                @endforeach
                            </select>

                            @error('bandara_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="nomor_surat"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nomor Surat
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="nomor_surat"
                                name="nomor_surat"
                                value="{{ old('nomor_surat') }}"
                                required
                                placeholder="Contoh: AU.101/123/DBU/2026"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('nomor_surat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="tanggal_surat"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Tanggal Surat
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="date"
                                id="tanggal_surat"
                                name="tanggal_surat"
                                value="{{ old('tanggal_surat') }}"
                                required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('tanggal_surat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label
                                for="perihal"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Perihal
                            </label>

                            <input
                                type="text"
                                id="perihal"
                                name="perihal"
                                value="{{ old('perihal') }}"
                                placeholder="Masukkan perihal surat"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('perihal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label
                                for="file_surat"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                File Surat PDF
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="file"
                                id="file_surat"
                                name="file_surat"
                                accept="application/pdf"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200"
                            >

                            <p class="mt-2 text-xs text-gray-500">
                                Format PDF dengan ukuran maksimal 5 MB.
                            </p>

                            @error('file_surat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label
                                for="keterangan"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Keterangan
                            </label>

                            <textarea
                                id="keterangan"
                                name="keterangan"
                                rows="4"
                                placeholder="Tambahkan keterangan apabila diperlukan"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >{{ old('keterangan') }}</textarea>

                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">
                                    Temuan yang Ditindaklanjuti
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Pilih bandara terlebih dahulu untuk menampilkan temuan berstatus Open.
                                </p>
                            </div>

                            <div
                                id="jumlah-temuan"
                                class="hidden rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700"
                            ></div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div
                            id="temuan-initial"
                            class="rounded-lg border border-dashed border-gray-300 px-6 py-10 text-center"
                        >
                            <p class="text-sm font-medium text-gray-700">
                                Belum ada bandara yang dipilih.
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Daftar temuan akan muncul secara otomatis setelah memilih bandara.
                            </p>
                        </div>

                        <div
                            id="temuan-loading"
                            class="hidden rounded-lg border border-gray-200 px-6 py-10 text-center"
                        >
                            <div class="mx-auto h-8 w-8 animate-spin rounded-full border-4 border-gray-200 border-t-indigo-600"></div>

                            <p class="mt-3 text-sm text-gray-500">
                                Memuat data temuan...
                            </p>
                        </div>

                        <div
                            id="temuan-empty"
                            class="hidden rounded-lg border border-yellow-200 bg-yellow-50 px-6 py-8 text-center"
                        >
                            <p class="text-sm font-medium text-yellow-800">
                                Tidak ada temuan Open pada bandara ini.
                            </p>
                        </div>

                        <div
                            id="temuan-error"
                            class="hidden rounded-lg border border-red-200 bg-red-50 px-6 py-8 text-center"
                        >
                            <p class="text-sm font-medium text-red-800">
                                Data temuan gagal dimuat.
                            </p>

                            <p class="mt-1 text-sm text-red-600">
                                Silakan pilih ulang bandara atau muat ulang halaman.
                            </p>
                        </div>

                        <div
                            id="temuan-list"
                            class="hidden space-y-4"
                        ></div>

                        @error('temuan_ids')
                            <p class="mt-4 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('laporan.index') }}"
                        class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        id="submit-button"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bandaraSelect = document.getElementById('bandara_id');
            const initialContainer = document.getElementById('temuan-initial');
            const loadingContainer = document.getElementById('temuan-loading');
            const emptyContainer = document.getElementById('temuan-empty');
            const errorContainer = document.getElementById('temuan-error');
            const listContainer = document.getElementById('temuan-list');
            const jumlahTemuan = document.getElementById('jumlah-temuan');

            const oldTemuanIds = @json(
                collect(old('temuan_ids', []))->map(fn ($id) => (string) $id)->values()
            );

            function hideAllStates() {
                initialContainer.classList.add('hidden');
                loadingContainer.classList.add('hidden');
                emptyContainer.classList.add('hidden');
                errorContainer.classList.add('hidden');
                listContainer.classList.add('hidden');
                jumlahTemuan.classList.add('hidden');
            }

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value ?? '-';

                return div.innerHTML;
            }

            function formatDate(value) {
                if (!value) {
                    return '-';
                }

                const date = new Date(value);

                if (Number.isNaN(date.getTime())) {
                    return value;
                }

                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                }).format(date);
            }

            function renderTemuans(temuans) {
                listContainer.innerHTML = '';

                temuans.forEach(function (temuan) {
                    const isChecked = oldTemuanIds.includes(String(temuan.id));

                    const item = document.createElement('label');

                    item.className =
                        'block cursor-pointer rounded-xl border border-gray-200 p-5 transition hover:border-indigo-300 hover:bg-indigo-50/30';

                    item.innerHTML = `
                        <div class="flex items-start gap-4">
                            <input
                                type="checkbox"
                                name="temuan_ids[]"
                                value="${escapeHtml(temuan.id)}"
                                ${isChecked ? 'checked' : ''}
                                class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            ${escapeHtml(temuan.nomor_temuan || 'Temuan #' + temuan.id)}
                                        </p>

                                        <p class="mt-1 text-sm leading-6 text-gray-700">
                                            ${escapeHtml(temuan.uraian_temuan)}
                                        </p>
                                    </div>

                                    ${
                                        temuan.tingkat_risiko
                                            ? `<span class="inline-flex w-fit rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                                ${escapeHtml(temuan.tingkat_risiko)}
                                            </span>`
                                            : ''
                                    }
                                </div>

                                <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-3">
                                    <div>
                                        <dt class="text-gray-500">Unsur/Elemen</dt>
                                        <dd class="mt-1 font-medium text-gray-800">
                                            ${escapeHtml(temuan.unsur_elemen)}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-gray-500">Lokasi</dt>
                                        <dd class="mt-1 font-medium text-gray-800">
                                            ${escapeHtml(temuan.lokasi)}
                                        </dd>
                                    </div>

                                    <div>
                                        <dt class="text-gray-500">Tanggal Inspeksi</dt>
                                        <dd class="mt-1 font-medium text-gray-800">
                                            ${escapeHtml(formatDate(temuan.tanggal_inspeksi))}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    `;

                    listContainer.appendChild(item);
                });

                jumlahTemuan.textContent = `${temuans.length} temuan Open`;
                jumlahTemuan.classList.remove('hidden');
                listContainer.classList.remove('hidden');
            }

            async function loadTemuans(bandaraId) {
                hideAllStates();
                listContainer.innerHTML = '';

                if (!bandaraId) {
                    initialContainer.classList.remove('hidden');
                    return;
                }

                loadingContainer.classList.remove('hidden');

                try {
                    const baseUrl = @json(url('/laporan/temuan-by-bandara'));
                    const response = await fetch(`${baseUrl}/${bandaraId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data temuan.');
                    }

                    const result = await response.json();
                    const temuans = Array.isArray(result.data) ? result.data : [];

                    hideAllStates();

                    if (temuans.length === 0) {
                        emptyContainer.classList.remove('hidden');
                        return;
                    }

                    renderTemuans(temuans);
                } catch (error) {
                    hideAllStates();
                    errorContainer.classList.remove('hidden');
                    console.error(error);
                }
            }

            bandaraSelect.addEventListener('change', function () {
                loadTemuans(this.value);
            });

            if (bandaraSelect.value) {
                loadTemuans(bandaraSelect.value);
            }
        });
    </script>

</div>

@endsection
