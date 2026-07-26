{{-- MODAL GLOBAL SEARCH --}}
<div
    x-show="searchOpen"
    x-transition.opacity
    class="fixed inset-0 z-[100] flex items-start justify-center
           bg-slate-950/60 px-4 pt-16 backdrop-blur-sm sm:pt-24"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-label="Pencarian global SITBA"
>
    <div
        @click.outside="closeSearch()"
        class="w-full max-w-2xl overflow-hidden rounded-2xl
               border border-slate-200 bg-white shadow-2xl"
    >
        {{-- Kolom pencarian --}}
        <div class="flex items-center gap-3 border-b border-slate-200 px-4">

            <svg
                class="h-6 w-6 shrink-0 text-slate-400"
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

            <input
                x-ref="globalSearchInput"

                @keydown.down.prevent="moveSearchSelection(1)"

                @keydown.up.prevent="moveSearchSelection(-1)"

                @keydown.enter.prevent="openSelectedSearchResult()"
                x-model="searchQuery"
                @input.debounce.300ms="performSearch()"
                type="search"
                placeholder="Cari bandara, inspeksi, temuan, atau laporan..."
                autocomplete="off"
                class="h-16 w-full border-0 bg-transparent
                       text-base text-slate-800 outline-none
                       placeholder:text-slate-400
                       focus:border-0 focus:outline-none focus:ring-0"
            >

            <button
                type="button"
                @click="closeSearch()"
                class="rounded-lg border border-slate-200 px-2 py-1
                       text-xs font-semibold text-slate-500
                       transition hover:bg-slate-100"
            >
                ESC
            </button>

        </div>


        {{-- Isi hasil pencarian --}}
        <div class="max-h-[65vh] overflow-y-auto p-3">

            {{-- Petunjuk awal --}}
            <div
                x-show="searchQuery.trim().length < 2"
                class="px-4 py-12 text-center"
            >
                <div
                    class="mx-auto mb-3 flex h-12 w-12 items-center
                           justify-center rounded-full bg-blue-50 text-2xl"
                >
                    🔍
                </div>

                <p class="font-semibold text-slate-700">
                    Cari seluruh data SITBA
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Masukkan minimal 2 karakter untuk mulai mencari.
                </p>
            </div>


            {{-- Loading --}}
            <div
                x-show="searchLoading"
                class="flex items-center justify-center gap-3 px-4 py-12
                       text-sm text-slate-500"
            >
                <svg
                    class="h-5 w-5 animate-spin"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373
                           0 12h4Zm2 5.291A7.962 7.962 0 0 1 4 12H0
                           c0 3.042 1.135 5.824 3 7.938l3-2.647Z"
                    ></path>
                </svg>

                <span>Mencari data...</span>
            </div>


            {{-- Error --}}
            <div
                x-show="!searchLoading && searchError"
                class="m-2 rounded-xl border border-red-200
                       bg-red-50 px-4 py-4 text-sm text-red-700"
                x-text="searchError"
            ></div>


            {{-- Tidak ditemukan --}}
            <div
                x-show="
                    !searchLoading &&
                    !searchError &&
                    searchQuery.trim().length >= 2 &&
                    totalSearchResults() === 0
                "
                class="px-4 py-12 text-center"
            >
                <div class="mb-2 text-3xl">
                    📭
                </div>

                <p class="font-semibold text-slate-700">
                    Data tidak ditemukan
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Coba gunakan kata kunci lainnya.
                </p>
            </div>


            {{-- Daftar hasil --}}
            <div
                x-show="
                    !searchLoading &&
                    !searchError &&
                    totalSearchResults() > 0
                "
                class="space-y-4"
            >
                <div
                    class="flex items-center justify-between rounded-xl
                           border border-slate-200 bg-slate-50
                           px-3 py-2 text-xs text-slate-500"
                >
                    <span>
                        Hasil pencarian
                    </span>

                    <span
                        class="rounded-full bg-blue-100 px-2.5 py-1
                               font-semibold text-blue-700"
                        x-text="`${totalSearchResults()} hasil ditemukan`"
                    ></span>
                </div>

                {{-- Bandara --}}
                <section x-show="searchResults.bandara.length > 0">

                    <p
                        class="mb-1 px-3 text-xs font-bold uppercase
                               tracking-wider text-slate-400"
                    >
                        🛫 Bandara
                    </p>

                    <template
                        x-for="item in searchResults.bandara"
                        :key="'bandara-' + item.id"
                    >
                        <a
                            :href="item.url"

                            data-global-search-result

                            @mouseenter="selectSearchResult($el)"

                            :class="

                                isSearchResultSelected($el)

                                    ? 'bg-blue-50 ring-1 ring-inset ring-blue-200'

                                    : ''

                            "

                            @click="closeSearch()"
                            class="flex items-center justify-between
                                   rounded-xl px-3 py-3 transition
                                   hover:bg-blue-50"
                        >
                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold
                                           text-slate-800"
                                    x-text="item.judul"
                                ></p>

                                <p
                                    class="mt-0.5 truncate text-xs
                                           text-slate-500"
                                    x-text="item.keterangan"
                                ></p>

                            </div>

                            <div class="ml-3 flex shrink-0 items-center gap-2">
                                <span
                                    class="hidden rounded-full px-2.5 py-1
                                           text-[11px] font-semibold sm:inline-flex
                                           bg-blue-100 text-blue-700"
                                >
                                    Bandara
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>
                            </div>
                        </a>
                    </template>

                </section>


                {{-- Inspeksi --}}
                <section x-show="searchResults.inspeksi.length > 0">

                    <p
                        class="mb-1 px-3 text-xs font-bold uppercase
                               tracking-wider text-slate-400"
                    >
                        🔍 Inspeksi
                    </p>

                    <template
                        x-for="item in searchResults.inspeksi"
                        :key="'inspeksi-' + item.id"
                    >
                        <a
                            :href="item.url"

                            data-global-search-result

                            @mouseenter="selectSearchResult($el)"

                            :class="

                                isSearchResultSelected($el)

                                    ? 'bg-blue-50 ring-1 ring-inset ring-blue-200'

                                    : ''

                            "

                            @click="closeSearch()"
                            class="flex items-center justify-between
                                   rounded-xl px-3 py-3 transition
                                   hover:bg-blue-50"
                        >
                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold
                                           text-slate-800"
                                    x-text="item.judul"
                                ></p>

                                <p
                                    class="mt-0.5 truncate text-xs
                                           text-slate-500"
                                    x-text="item.keterangan"
                                ></p>

                            </div>

                            <div class="ml-3 flex shrink-0 items-center gap-2">
                                <span
                                    x-show="item.tahun"
                                    x-text="item.tahun"
                                    class="rounded-full bg-slate-100 px-2.5 py-1
                                           text-[11px] font-semibold text-slate-600"
                                ></span>

                                <span
                                    class="hidden rounded-full px-2.5 py-1
                                           text-[11px] font-semibold sm:inline-flex
                                           bg-indigo-100 text-indigo-700"
                                >
                                    Inspeksi
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>
                            </div>
                        </a>
                    </template>

                </section>


                {{-- Temuan --}}
                <section x-show="searchResults.temuan.length > 0">

                    <p
                        class="mb-1 px-3 text-xs font-bold uppercase
                               tracking-wider text-slate-400"
                    >
                        ⚠️ Temuan
                    </p>

                    <template
                        x-for="item in searchResults.temuan"
                        :key="'temuan-' + item.id"
                    >
                        <a
                            :href="item.url"

                            data-global-search-result

                            @mouseenter="selectSearchResult($el)"

                            :class="

                                isSearchResultSelected($el)

                                    ? 'bg-blue-50 ring-1 ring-inset ring-blue-200'

                                    : ''

                            "

                            @click="closeSearch()"
                            class="flex items-center justify-between
                                   rounded-xl px-3 py-3 transition
                                   hover:bg-amber-50"
                        >
                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold
                                           text-slate-800"
                                    x-text="item.judul"
                                ></p>

                                <p
                                    class="mt-0.5 truncate text-xs
                                           text-slate-500"
                                    x-text="item.keterangan"
                                ></p>

                            </div>

                            <div class="ml-3 flex shrink-0 items-center gap-2">
                                <span
                                    x-show="item.tahun"
                                    x-text="item.tahun"
                                    class="rounded-full bg-slate-100 px-2.5 py-1
                                           text-[11px] font-semibold text-slate-600"
                                ></span>

                                <span
                                    x-show="item.risiko"
                                    x-text="item.risiko"
                                    :class="
                                        item.risiko === 'Tinggi'
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-green-100 text-green-700'
                                    "
                                    class="hidden rounded-full px-2.5 py-1
                                           text-[11px] font-semibold sm:inline-flex"
                                ></span>

                                <span
                                    class="hidden rounded-full px-2.5 py-1
                                           text-[11px] font-semibold sm:inline-flex
                                           bg-amber-100 text-amber-700"
                                >
                                    Temuan
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>
                            </div>
                        </a>
                    </template>

                </section>


                {{-- Laporan --}}
                <section x-show="searchResults.laporan.length > 0">

                    <p
                        class="mb-1 px-3 text-xs font-bold uppercase
                               tracking-wider text-slate-400"
                    >
                        📄 Laporan
                    </p>

                    <template
                        x-for="item in searchResults.laporan"
                        :key="'laporan-' + item.id"
                    >
                        <a
                            :href="item.url"

                            data-global-search-result

                            @mouseenter="selectSearchResult($el)"

                            :class="

                                isSearchResultSelected($el)

                                    ? 'bg-blue-50 ring-1 ring-inset ring-blue-200'

                                    : ''

                            "

                            @click="closeSearch()"
                            class="flex items-center justify-between
                                   rounded-xl px-3 py-3 transition
                                   hover:bg-emerald-50"
                        >
                            <div class="min-w-0">

                                <p
                                    class="truncate text-sm font-semibold
                                           text-slate-800"
                                    x-text="item.judul"
                                ></p>

                                <p
                                    class="mt-0.5 truncate text-xs
                                           text-slate-500"
                                    x-text="item.keterangan"
                                ></p>

                            </div>

                            <div class="ml-3 flex shrink-0 items-center gap-2">
                                <span
                                    x-show="item.tahun"
                                    x-text="item.tahun"
                                    class="rounded-full bg-slate-100 px-2.5 py-1
                                           text-[11px] font-semibold text-slate-600"
                                ></span>

                                <span
                                    class="hidden rounded-full px-2.5 py-1
                                           text-[11px] font-semibold sm:inline-flex
                                           bg-emerald-100 text-emerald-700"
                                >
                                    Laporan
                                </span>

                                <span class="text-slate-300">
                                    →
                                </span>
                            </div>
                        </a>
                    </template>

                </section>

            </div>

        </div>


        {{-- Footer modal --}}
        <div
            class="flex items-center justify-between border-t
                   border-slate-200 bg-slate-50 px-4 py-3
                   text-xs text-slate-500"
        >
            <span>
                ↑↓ pilih • Enter buka • Esc tutup
            </span>

            <span x-show="totalSearchResults() > 0">
                <strong x-text="totalSearchResults()"></strong>
                hasil ditemukan
            </span>
        </div>

    </div>
</div>
