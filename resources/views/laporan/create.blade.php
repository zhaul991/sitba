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

                        <div id="temuan-wrapper" class="hidden">
                            <div class="mb-5 space-y-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                                    <div class="md:col-span-1">
                                        <label for="search-temuan" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Cari Temuan
                                        </label>

                                        <input
                                            type="search"
                                            id="search-temuan"
                                            placeholder="Nomor, uraian, unsur, atau lokasi..."
                                            class="block w-full rounded-lg border-gray-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                    </div>

                                    <div>
                                        <label for="filter-tahun-temuan" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Tahun Inspeksi
                                        </label>

                                        <select
                                            id="filter-tahun-temuan"
                                            class="block w-full rounded-lg border-gray-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            <option value="">Semua Tahun</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="filter-risiko-temuan" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                                            Tingkat Risiko
                                        </label>

                                        <select
                                            id="filter-risiko-temuan"
                                            class="block w-full rounded-lg border-gray-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            <option value="">Semua Risiko</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-3 border-t border-gray-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
                                    <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-gray-700">
                                        <input
                                            type="checkbox"
                                            id="check-all-temuan"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                        >
                                        Pilih semua hasil yang tampil
                                    </label>

                                    <p id="ringkasan-pilihan" class="text-sm font-medium text-gray-600">
                                        0 temuan dipilih
                                    </p>
                                </div>
                            </div>

                            <div
                                id="temuan-filter-empty"
                                class="hidden rounded-lg border border-dashed border-gray-300 px-6 py-8 text-center"
                            >
                                <p class="text-sm font-medium text-gray-700">
                                    Tidak ada temuan yang cocok dengan pencarian atau filter.
                                </p>
                            </div>

                            <div
                                id="temuan-list"
                                class="space-y-4"
                            ></div>
                        </div>

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

            const wrapperContainer = document.getElementById('temuan-wrapper');
            const listContainer = document.getElementById('temuan-list');
            const filterEmptyContainer = document.getElementById('temuan-filter-empty');

            const searchInput = document.getElementById('search-temuan');
            const tahunFilter = document.getElementById('filter-tahun-temuan');
            const risikoFilter = document.getElementById('filter-risiko-temuan');
            const checkAllTemuan = document.getElementById('check-all-temuan');

            const jumlahTemuan = document.getElementById('jumlah-temuan');
            const ringkasanPilihan = document.getElementById('ringkasan-pilihan');

            const oldTemuanIds = @json(
                collect(old('temuan_ids', []))
                    ->map(fn ($id) => (string) $id)
                    ->values()
            );

            let semuaTemuan = [];
            let temuanTampil = [];
            const selectedIds = new Set(oldTemuanIds);

            function hideAllStates() {
                initialContainer.classList.add('hidden');
                loadingContainer.classList.add('hidden');
                emptyContainer.classList.add('hidden');
                errorContainer.classList.add('hidden');
                wrapperContainer.classList.add('hidden');
                jumlahTemuan.classList.add('hidden');
            }

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value ?? '-';

                return div.innerHTML;
            }

            function normalizeDate(value) {
                if (!value) {
                    return null;
                }

                const date = new Date(String(value).replace(' ', 'T'));

                return Number.isNaN(date.getTime()) ? null : date;
            }

            function formatDate(value) {
                const date = normalizeDate(value);

                if (!date) {
                    return value || '-';
                }

                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                }).format(date);
            }

            function getYear(value) {
                const date = normalizeDate(value);

                return date ? String(date.getFullYear()) : '';
            }

            function getRiskBadgeClasses(risk) {
                const normalizedRisk = String(risk || '').toLowerCase();

                if (normalizedRisk.includes('tinggi')) {
                    return 'bg-red-50 text-red-700 ring-red-200';
                }

                if (normalizedRisk.includes('sedang')) {
                    return 'bg-yellow-50 text-yellow-700 ring-yellow-200';
                }

                if (normalizedRisk.includes('rendah')) {
                    return 'bg-green-50 text-green-700 ring-green-200';
                }

                return 'bg-gray-100 text-gray-700 ring-gray-200';
            }

            function updateCardState(card, checkbox) {
                const statusBadge = card.querySelector('[data-selected-badge]');

                if (checkbox.checked) {
                    card.classList.remove(
                        'border-gray-200',
                        'bg-white'
                    );

                    card.classList.add(
                        'border-indigo-400',
                        'bg-indigo-50',
                        'ring-1',
                        'ring-indigo-200'
                    );

                    statusBadge?.classList.remove('hidden');
                } else {
                    card.classList.remove(
                        'border-indigo-400',
                        'bg-indigo-50',
                        'ring-1',
                        'ring-indigo-200'
                    );

                    card.classList.add(
                        'border-gray-200',
                        'bg-white'
                    );

                    statusBadge?.classList.add('hidden');
                }
            }

            function updateSelectionSummary() {
                const selectedVisibleCount = temuanTampil.filter(function (temuan) {
                    return selectedIds.has(String(temuan.id));
                }).length;

                const totalSelectedCount = selectedIds.size;
                const visibleCount = temuanTampil.length;
                const totalCount = semuaTemuan.length;

                ringkasanPilihan.textContent =
                    `${totalSelectedCount} temuan dipilih • ` +
                    `${visibleCount} ditampilkan dari ${totalCount} Open`;

                jumlahTemuan.textContent =
                    totalSelectedCount > 0
                        ? `${totalSelectedCount} temuan dipilih`
                        : `${totalCount} temuan Open`;

                jumlahTemuan.classList.remove('hidden');

                checkAllTemuan.checked =
                    visibleCount > 0 &&
                    selectedVisibleCount === visibleCount;

                checkAllTemuan.indeterminate =
                    selectedVisibleCount > 0 &&
                    selectedVisibleCount < visibleCount;

                checkAllTemuan.disabled = visibleCount === 0;
            }

            function populateFilters(temuans) {
                const years = [...new Set(
                    temuans
                        .map(function (temuan) {
                            return getYear(temuan.tanggal_inspeksi);
                        })
                        .filter(Boolean)
                )].sort(function (a, b) {
                    return Number(b) - Number(a);
                });

                tahunFilter.innerHTML =
                    '<option value="">Semua Tahun</option>';

                years.forEach(function (year) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    tahunFilter.appendChild(option);
                });

                const risks = [...new Set(
                    temuans
                        .map(function (temuan) {
                            return String(temuan.tingkat_risiko || '').trim();
                        })
                        .filter(Boolean)
                )].sort(function (a, b) {
                    return a.localeCompare(b, 'id');
                });

                risikoFilter.innerHTML =
                    '<option value="">Semua Risiko</option>';

                risks.forEach(function (risk) {
                    const option = document.createElement('option');
                    option.value = risk;
                    option.textContent = risk;
                    risikoFilter.appendChild(option);
                });
            }

            function renderTemuans(temuans) {
                listContainer.innerHTML = '';
                temuanTampil = temuans;

                if (temuans.length === 0) {
                    filterEmptyContainer.classList.remove('hidden');
                    updateSelectionSummary();
                    return;
                }

                filterEmptyContainer.classList.add('hidden');

                temuans.forEach(function (temuan) {
                    const temuanId = String(temuan.id);
                    const isChecked = selectedIds.has(temuanId);

                    const item = document.createElement('label');

                    item.className =
                        'block cursor-pointer rounded-xl border border-gray-200 bg-white p-5 transition hover:border-indigo-300 hover:bg-indigo-50/40';

                    item.dataset.temuanCard = temuanId;

                    item.innerHTML = `
                        <div class="flex items-start gap-4">
                            <input
                                type="checkbox"
                                name="temuan_ids[]"
                                value="${escapeHtml(temuan.id)}"
                                ${isChecked ? 'checked' : ''}
                                class="temuan-checkbox mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold text-gray-900">
                                                ${escapeHtml(
                                                    temuan.nomor_temuan ||
                                                    'Temuan #' + temuan.id
                                                )}
                                            </p>

                                            <span
                                                data-selected-badge
                                                class="${isChecked ? '' : 'hidden'} inline-flex rounded-full bg-indigo-600 px-2.5 py-1 text-xs font-semibold text-white"
                                            >
                                                Akan Ditutup
                                            </span>
                                        </div>

                                        <p class="mt-2 text-sm leading-6 text-gray-700">
                                            ${escapeHtml(temuan.uraian_temuan)}
                                        </p>
                                    </div>

                                    ${
                                        temuan.tingkat_risiko
                                            ? `
                                                <span
                                                    class="inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset ${getRiskBadgeClasses(temuan.tingkat_risiko)}"
                                                >
                                                    ${escapeHtml(temuan.tingkat_risiko)}
                                                </span>
                                            `
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
                                            ${escapeHtml(
                                                formatDate(temuan.tanggal_inspeksi)
                                            )}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    `;

                    const checkbox = item.querySelector('.temuan-checkbox');

                    updateCardState(item, checkbox);

                    checkbox.addEventListener('change', function () {
                        if (this.checked) {
                            selectedIds.add(temuanId);
                        } else {
                            selectedIds.delete(temuanId);
                        }

                        updateCardState(item, this);
                        updateSelectionSummary();
                    });

                    listContainer.appendChild(item);
                });

                updateSelectionSummary();
            }

            function applyFilters() {
                const keyword = searchInput.value
                    .trim()
                    .toLowerCase();

                const selectedYear = tahunFilter.value;
                const selectedRisk = risikoFilter.value;

                const filtered = semuaTemuan.filter(function (temuan) {
                    const searchableText = [
                        temuan.nomor_temuan,
                        temuan.uraian_temuan,
                        temuan.unsur_elemen,
                        temuan.lokasi,
                    ]
                        .map(function (value) {
                            return String(value || '').toLowerCase();
                        })
                        .join(' ');

                    const matchesKeyword =
                        !keyword ||
                        searchableText.includes(keyword);

                    const matchesYear =
                        !selectedYear ||
                        getYear(temuan.tanggal_inspeksi) === selectedYear;

                    const matchesRisk =
                        !selectedRisk ||
                        String(temuan.tingkat_risiko || '') === selectedRisk;

                    return matchesKeyword && matchesYear && matchesRisk;
                });

                renderTemuans(filtered);
            }

            function resetFilters() {
                searchInput.value = '';
                tahunFilter.value = '';
                risikoFilter.value = '';
                checkAllTemuan.checked = false;
                checkAllTemuan.indeterminate = false;
            }

            async function loadTemuans(bandaraId) {
                hideAllStates();
                listContainer.innerHTML = '';
                semuaTemuan = [];
                temuanTampil = [];

                if (!bandaraId) {
                    initialContainer.classList.remove('hidden');
                    return;
                }

                loadingContainer.classList.remove('hidden');

                try {
                    const baseUrl = @json(
                        url('/laporan/temuan-by-bandara')
                    );

                    const response = await fetch(
                        `${baseUrl}/${bandaraId}`,
                        {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            `Gagal mengambil data temuan. HTTP ${response.status}`
                        );
                    }

                    const result = await response.json();

                    semuaTemuan = Array.isArray(result.data)
                        ? result.data
                        : [];

                    hideAllStates();

                    if (semuaTemuan.length === 0) {
                        emptyContainer.classList.remove('hidden');
                        return;
                    }

                    populateFilters(semuaTemuan);
                    wrapperContainer.classList.remove('hidden');
                    renderTemuans(semuaTemuan);
                } catch (error) {
                    hideAllStates();
                    errorContainer.classList.remove('hidden');
                    console.error(error);
                }
            }

            searchInput.addEventListener('input', applyFilters);
            tahunFilter.addEventListener('change', applyFilters);
            risikoFilter.addEventListener('change', applyFilters);

            checkAllTemuan.addEventListener('change', function () {
                const shouldCheck = this.checked;

                temuanTampil.forEach(function (temuan) {
                    const temuanId = String(temuan.id);

                    if (shouldCheck) {
                        selectedIds.add(temuanId);
                    } else {
                        selectedIds.delete(temuanId);
                    }
                });

                renderTemuans(temuanTampil);
            });

            bandaraSelect.addEventListener('change', function () {
                selectedIds.clear();
                resetFilters();
                loadTemuans(this.value);
            });

            if (bandaraSelect.value) {
                loadTemuans(bandaraSelect.value);
            }
        });
    </script>

</div>

@endsection
