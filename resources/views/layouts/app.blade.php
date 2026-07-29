<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'SITBA')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-slate-100 text-slate-800">

<div
    x-data="{
        sidebarOpen: false,
        searchOpen: false,
        searchQuery: '',
        searchLoading: false,
        searchError: '',
        selectedSearchIndex: -1,
        searchResults: {
            bandara: [],
            inspeksi: [],
            temuan: [],
            laporan: []
        },

        openSearch() {
            this.searchOpen = true;
            this.searchError = '';
            this.selectedSearchIndex = -1;

            this.$nextTick(() => {
                this.$refs.globalSearchInput.focus();
            });
        },

        closeSearch() {
            this.searchOpen = false;
            this.searchQuery = '';
            this.searchLoading = false;
            this.searchError = '';
            this.selectedSearchIndex = -1;

            this.searchResults = {
                bandara: [],
                inspeksi: [],
                temuan: [],
                laporan: []
            };
        },

        totalSearchResults() {
            return Object.values(this.searchResults)
                .reduce((total, items) => total + items.length, 0);
        },

        searchResultElements() {
            return Array.from(
                this.$root.querySelectorAll(
                    '[data-global-search-result]'
                )
            );
        },

        selectSearchResult(element) {
            const elements = this.searchResultElements();

            this.selectedSearchIndex =
                elements.indexOf(element);
        },

        isSearchResultSelected(element) {
            const elements = this.searchResultElements();

            return this.selectedSearchIndex ===
                elements.indexOf(element);
        },

        moveSearchSelection(direction) {
            const elements = this.searchResultElements();

            if (elements.length === 0) {
                this.selectedSearchIndex = -1;
                return;
            }

            if (this.selectedSearchIndex < 0) {
                this.selectedSearchIndex =
                    direction > 0
                        ? 0
                        : elements.length - 1;
            } else {
                this.selectedSearchIndex =
                    (
                        this.selectedSearchIndex
                        + direction
                        + elements.length
                    ) % elements.length;
            }

            this.$nextTick(() => {
                this.scrollSelectedSearchResult();
            });
        },

        scrollSelectedSearchResult() {
            const elements = this.searchResultElements();

            const selectedElement =
                elements[this.selectedSearchIndex];

            selectedElement?.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        },

        openSelectedSearchResult() {
            const elements = this.searchResultElements();

            if (elements.length === 0) {
                return;
            }

            if (this.selectedSearchIndex < 0) {
                this.selectedSearchIndex = 0;
            }

            const selectedElement =
                elements[this.selectedSearchIndex];

            if (!selectedElement?.href) {
                return;
            }

            window.location.href = selectedElement.href;
        },        async performSearch() {
            const keyword = this.searchQuery.trim();

            if (keyword.length < 2) {
                this.searchLoading = false;
                this.searchError = '';
                this.selectedSearchIndex = -1;

                this.searchResults = {
                    bandara: [],
                    inspeksi: [],
                    temuan: [],
                    laporan: []
                };

                return;
            }

            const requestedKeyword = keyword;

            this.searchLoading = true;
            this.searchError = '';

            try {
                const response = await fetch(
                    `{{ route('search') }}?q=${encodeURIComponent(keyword)}`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Pencarian gagal dijalankan.');
                }

                const data = await response.json();

                if (this.searchQuery.trim() !== requestedKeyword) {
                    return;
                }

                this.searchResults = {
                    bandara: data.bandara ?? [],
                    inspeksi: data.inspeksi ?? [],
                    temuan: data.temuan ?? [],
                    laporan: data.laporan ?? []
                };

                this.selectedSearchIndex =
                    this.totalSearchResults() > 0
                        ? 0
                        : -1;

                this.$nextTick(() => {
                    this.scrollSelectedSearchResult();
                });
            } catch (error) {
                this.selectedSearchIndex = -1;
                this.searchResults = {
                    bandara: [],
                    inspeksi: [],
                    temuan: [],
                    laporan: []
                };

                this.searchError =
                    'Terjadi kesalahan saat mencari data. Silakan coba kembali.';
            } finally {
                if (this.searchQuery.trim() === requestedKeyword) {
                    this.searchLoading = false;
                }
            }
        }
    }"
    @keydown.window.prevent.meta.k="openSearch()"
    @keydown.window.prevent.ctrl.k="openSearch()"
    @keydown.window.escape="closeSearch()"
    class="min-h-screen"
>

    {{-- Overlay saat sidebar dibuka di HP --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        style="display: none;"
    ></div>


    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col
               bg-slate-900 text-white shadow-xl
               transition-transform duration-300
               lg:translate-x-0"
    >

        {{-- Logo --}}
        <div class="flex h-20 items-center border-b border-slate-700 px-5">

            <a
                href="{{ url('/dashboard') }}"
                class="flex items-center gap-3"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-xl shadow">
                    ✈️
                </div>

                <div>

                    <div class="text-xl font-bold leading-none">
                        SITBA
                    </div>

                    <div class="mt-1 text-xs text-slate-400">
                        Temuan Bandar Udara
                    </div>

                </div>

            </a>

        </div>


        {{-- Menu --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5">

            {{-- Utama --}}
            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Utama
            </p>

            <a
                href="{{ url('/dashboard') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->is('dashboard')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>📊</span>
                <span>Dashboard</span>
            </a>


            @if(auth()->user()->canModify())

            {{-- Master Data --}}
            <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Master Data
            </p>

            <a
                href="{{ route('bandara.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('bandara.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>🛫</span>
                <span>Data Bandara</span>
            </a>

            <a
                href="{{ route('petugas.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('petugas.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>👷</span>
                <span>Data Inspektur</span>
            </a>




            @endif


            @if(auth()->user()->canModify())

            {{-- KEGIATAN PENGAWASAN --}}
            <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Kegiatan Pengawasan
            </p>

            <a
                href="{{ route('inspeksi.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('inspeksi.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>📋</span>
                <span>Inspeksi</span>
            </a>

            <a
                href="{{ route('pemantauan.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('pemantauan.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>👁️</span>
                <span>Pemantauan</span>
            </a>

            <a
                href="{{ route('pengamatan.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('pengamatan.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>🔎</span>
                <span>Pengamatan</span>
            </a>

            <a
                href="{{ route('audit.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('audit.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>📝</span>
                <span>Audit</span>
            </a>



            @endif

            {{-- HASIL PENGAWASAN --}}
            <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Hasil Pengawasan
            </p>

            <a
                href="{{ route('temuan.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('temuan.*') || request()->routeIs('fototemuan.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>⚠️</span>
                <span>Database Temuan</span>
            </a>

            
            <a
                href="{{ route('hasil-pengawasan.pemantauan') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('hasil-pengawasan.pemantauan')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>👁️</span>
                <span>Hasil Pemantauan</span>
            </a>

            <a
                href="{{ route('hasil-pengawasan.pengamatan') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('hasil-pengawasan.pengamatan')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>🔎</span>
                <span>Hasil Pengamatan</span>
            </a>

            <a
                href="{{ route('hasil-pengawasan.audit') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('hasil-pengawasan.audit')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>📝</span>
                <span>Hasil Audit</span>
            </a>

<a
                href="{{ route('laporan.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('laporan.*') || request()->routeIs('tindaklanjut.*')
                    ? 'bg-blue-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>📄</span>
                <span>Laporan Tindak Lanjut</span>


                
            </a>


            <a
                href="{{ route('warning-center.index') }}"
                class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                text-sm font-medium transition
                {{ request()->routeIs('warning-center.*')
                    ? 'bg-red-600 text-white shadow'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>🚨</span>
                <span>Warning Center</span>
            </a>

            {{-- AKTIVITAS --}}
            <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Aktivitas
            </p>

            <a
                href="{{ route('aktivitas.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold
                       transition
                       {{ request()->routeIs('aktivitas.*')
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <span>🕘</span>
                <span>Riwayat Aktivitas</span>
            </a>



                @if(auth()->user()->canModify())

                <div class="mt-6 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    DRAFT INSPEKSI
                </div>



                <a
                    href="{{ route('draft.index') }}"
                    class="mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5
                    text-sm font-medium transition
                    {{ request()->routeIs('draft.*')
                        ? 'bg-blue-600 text-white shadow'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                >
                    <span>📁</span>
                    <span>Draft Center</span>
                </a>

                @endif


</nav>


        {{-- Profil pengguna --}}
        <div class="border-t border-slate-700 p-4">

            <div class="mb-3 flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-700 font-bold text-white">
                    {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : '?' }}
                </div>

                <div class="min-w-0">

                    <div class="truncate text-sm font-semibold">
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </div>

                    <div class="truncate text-xs text-slate-400">
                        {{ Auth::check() ? Auth::user()->email : 'Belum login' }}
                    </div>

                </div>

            </div>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg
                           bg-slate-800 px-3 py-2 text-sm font-medium
                           text-slate-200 transition
                           hover:bg-red-600 hover:text-white"
                >
                    <span>🚪</span>
                    <span>Keluar</span>
                </button>

            </form>

        </div>

    </aside>


    {{-- KONTEN UTAMA --}}
    <div class="min-h-screen lg:ml-64">

        {{-- Header --}}
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white shadow-sm">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6">

                <div class="flex items-center gap-3">

                    {{-- Tombol mobile --}}
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="rounded-lg border border-slate-200 p-2 text-slate-600
                               transition hover:bg-slate-100 lg:hidden"
                    >
                        <span class="sr-only">
                            Buka menu
                        </span>

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div>

                        <h1 class="text-base font-bold text-slate-800 sm:text-lg">
                            @yield('page-title', 'Sistem Informasi Temuan Bandar Udara')
                        </h1>

                        <p class="hidden text-xs text-slate-500 sm:block">
                            Kantor Otoritas Bandar Udara Wilayah V Makassar
                        </p>

                    </div>

                </div>


                {{-- Global Search --}}
                <button
                    type="button"
                    @click="openSearch()"
                    class="ml-auto mr-3 flex items-center gap-3 rounded-xl
                           border border-slate-200 bg-slate-50
                           px-3 py-2 text-sm text-slate-500
                           shadow-sm transition
                           hover:border-blue-300 hover:bg-blue-50
                           hover:text-blue-700 sm:px-4"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0
                               7 7 0 0 1 14 0Z"
                        />
                    </svg>

                    <span class="hidden md:inline">
                        Cari data SITBA
                    </span>

                    <span
                        class="hidden rounded-md border border-slate-300
                               bg-white px-2 py-0.5 text-xs font-semibold
                               text-slate-500 lg:inline"
                    >
                        ⌘ K
                    </span>
                </button>


                {{-- Profil kanan --}}
                <div class="hidden items-center gap-3 sm:flex">

                    <div class="text-right">

                        <div class="text-sm font-semibold text-slate-700">
                            {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                        </div>

                        <div class="text-xs text-slate-500">
                            Pengguna SITBA
                        </div>

                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700">
                        {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : '?' }}
                    </div>

                </div>

            </div>

        </header>


        {{-- Flash notification --}}
        <div class="px-4 pt-5 sm:px-6">

            @if (session('success'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="mb-4 flex items-start justify-between rounded-xl
                           border border-emerald-200 bg-emerald-50
                           px-4 py-3 text-emerald-800 shadow-sm"
                >

                    <div class="flex items-start gap-3">

                        <span class="mt-0.5">
                            ✅
                        </span>

                        <div>

                            <p class="font-semibold">
                                Berhasil
                            </p>

                            <p class="text-sm">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                    <button
                        type="button"
                        @click="show = false"
                        class="ml-4 text-xl leading-none text-emerald-600
                               hover:text-emerald-900"
                    >
                        &times;
                    </button>

                </div>

            @endif


            @if (session('error'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="mb-4 flex items-start justify-between rounded-xl
                           border border-red-200 bg-red-50
                           px-4 py-3 text-red-800 shadow-sm"
                >

                    <div class="flex items-start gap-3">

                        <span class="mt-0.5">
                            ❌
                        </span>

                        <div>

                            <p class="font-semibold">
                                Gagal
                            </p>

                            <p class="text-sm">
                                {{ session('error') }}
                            </p>

                        </div>

                    </div>

                    <button
                        type="button"
                        @click="show = false"
                        class="ml-4 text-xl leading-none text-red-600
                               hover:text-red-900"
                    >
                        &times;
                    </button>

                </div>

            @endif


            @if (session('warning'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="mb-4 flex items-start justify-between rounded-xl
                           border border-amber-200 bg-amber-50
                           px-4 py-3 text-amber-800 shadow-sm"
                >

                    <div class="flex items-start gap-3">

                        <span class="mt-0.5">
                            ⚠️
                        </span>

                        <div>

                            <p class="font-semibold">
                                Perhatian
                            </p>

                            <p class="text-sm">
                                {{ session('warning') }}
                            </p>

                        </div>

                    </div>

                    <button
                        type="button"
                        @click="show = false"
                        class="ml-4 text-xl leading-none text-amber-600
                               hover:text-amber-900"
                    >
                        &times;
                    </button>

                </div>

            @endif


            @if ($errors->any())

                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm">

                    <div class="mb-2 flex items-center gap-2 font-semibold">
                        <span>⚠️</span>
                        <span>Data belum dapat disimpan</span>
                    </div>

                    <ul class="list-inside list-disc space-y-1 text-sm">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

        </div>


        {{-- Isi setiap halaman --}}
        <main class="px-4 pb-10 sm:px-6">

            @yield('content')

        </main>

    </div>

<x-global-search />


</div>

@stack('scripts')
</body>

</html>