@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Edit Temuan
        </h1>

        <p class="mt-2 text-gray-500">
            Perbarui informasi temuan hasil inspeksi bandar udara.
        </p>
    </div>

    <div class="max-w-4xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <p class="font-semibold">
                    Data temuan belum dapat disimpan.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="form-edit-temuan"
            action="{{ route('temuan.update', $temuan) }}"
            method="POST"
            enctype="multipart/form-data"
            data-status-awal="{{ $temuan->status }}"
        >
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label
                        for="inspeksi_id"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Kegiatan Inspeksi
                    </label>

                    <select
                        id="inspeksi_id"
                        name="inspeksi_id"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">
                            Pilih kegiatan inspeksi
                        </option>

                        @foreach ($inspeksis as $inspeksi)
                            <option
                                value="{{ $inspeksi->id }}"
                                @selected(
                                    old('inspeksi_id', $temuan->inspeksi_id) == $inspeksi->id
                                )
                            >
                                {{ $inspeksi->bandara?->nama_bandara ?? 'Bandara tidak tersedia' }}
                                — {{ $inspeksi->tanggal?->format('d-m-Y') ?? '-' }}
                            </option>
                        @endforeach
                    </select>

                    @error('inspeksi_id')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label
                            for="nomor_temuan"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Nomor Temuan
                        </label>

                        <input
                            type="text"
                            id="nomor_temuan"
                            name="nomor_temuan"
                            value="{{ old('nomor_temuan', $temuan->nomor_temuan) }}"
                            placeholder="Masukkan nomor temuan"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            Diisi sesuai nomor surat yang diterbitkan oleh Kantor Otoritas Bandar Udara.
                        </p>

                        @error('nomor_temuan')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="unsur_elemen"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Unsur / Elemen
                        </label>

                        <input
                            type="text"
                            id="unsur_elemen"
                            name="unsur_elemen"
                            value="{{ old('unsur_elemen', $temuan->unsur_elemen) }}"
                            placeholder="Contoh: Runway, Apron, Terminal"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >

                        @error('unsur_elemen')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label
                        for="uraian_temuan"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Uraian Temuan
                    </label>

                    <textarea
                        id="uraian_temuan"
                        name="uraian_temuan"
                        rows="6"
                        placeholder="Jelaskan kondisi temuan secara lengkap..."
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >{{ old('uraian_temuan', $temuan->uraian_temuan) }}</textarea>

                    @error('uraian_temuan')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label
                            for="lokasi"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Lokasi Temuan
                        </label>

                        <input
                            type="text"
                            id="lokasi"
                            name="lokasi"
                            value="{{ old('lokasi', $temuan->lokasi) }}"
                            placeholder="Contoh: Runway 03, Apron sisi utara"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >

                        @error('lokasi')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="tingkat_risiko"
                            class="mb-2 block text-sm font-semibold text-gray-700"
                        >
                            Tingkat Risiko
                        </label>

                        <select
                            id="tingkat_risiko"
                            name="tingkat_risiko"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            
                            <option value="">Pilih tingkat risiko</option>

                            @foreach (config('sitba.risiko') as $risiko)
                                <option
                                    value="{{ $risiko }}"
                                    @selected(
                                        old(
                                            'tingkat_risiko',
                                            $temuan->tingkat_risiko
                                        ) === $risiko
                                    )
                                >
                                    {{ $risiko }}
                                </option>
                            @endforeach

                        </select>

                        @error('tingkat_risiko')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label
                        for="due_date"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Due Date
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old('due_date', $temuan->due_date ? \Carbon\Carbon::parse($temuan->due_date)->format('Y-m-d') : '') }}"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('due_date')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Status Temuan
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        
                        <option value="">Pilih status</option>

                        @foreach (config('sitba.status') as $status)
                            <option
                                value="{{ $status }}"
                                @selected(
                                    old('status', $temuan->status) === $status
                                )
                            >
                                {{ $status }}
                            </option>
                        @endforeach

                    </select>

                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>



                <div
                    id="peringatan-penutupan"
                    class="hidden rounded-xl border border-amber-200 bg-amber-50 px-5 py-4"
                >
                    <div class="flex items-start gap-3">
                        <div class="text-xl">
                            ⚠️
                        </div>

                        <div>
                            <p class="font-bold text-amber-800">
                                Perhatian sebelum menutup temuan
                            </p>

                            <p class="mt-2 text-sm leading-relaxed text-amber-700">
                                Pastikan seluruh tindak lanjut telah selesai dan seluruh
                                dokumen telah diverifikasi sebelum mengubah status temuan
                                menjadi Close.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    id="bagian-penutupan"
                    class="hidden rounded-2xl border border-green-200 bg-green-50 p-5"
                >
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-green-900">
                            Informasi Penutupan
                        </h2>

                        <p class="mt-1 text-sm text-green-700">
                            Lengkapi informasi berikut sebagai dasar penutupan temuan.
                        </p>
                    </div>

                    <div class="space-y-5">

                        <div>
                            <label
                                for="tanggal_close"
                                class="mb-2 block text-sm font-semibold text-green-900"
                            >
                                Tanggal Penutupan
                            </label>

                            <input
                                type="date"
                                id="tanggal_close"
                                name="tanggal_close"
                                value="{{ old(
                                    'tanggal_close',
                                    $temuan->tanggal_close?->format('Y-m-d')
                                ) }}"
                                class="w-full rounded-xl border-green-300 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            >

                            @error('tanggal_close')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="keterangan_penutupan"
                                class="mb-2 block text-sm font-semibold text-green-900"
                            >
                                Keterangan Penutupan
                            </label>

                            <textarea
                                id="keterangan_penutupan"
                                name="keterangan_penutupan"
                                rows="4"
                                placeholder="Contoh: Seluruh dokumen telah diverifikasi."
                                class="w-full rounded-xl border-green-300 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            >{{ old(
                                'keterangan_penutupan',
                                $temuan->keterangan_penutupan
                            ) }}</textarea>

                            <p class="mt-2 text-xs text-green-700">
                                Jelaskan secara singkat dasar penutupan temuan.
                            </p>

                            @error('keterangan_penutupan')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label
                                for="dokumen_penutupan"
                                class="mb-2 block text-sm font-semibold text-green-900"
                            >
                                Dokumen Tindak Lanjut (PDF)
                            </label>

                            <input
                                type="file"
                                id="dokumen_penutupan"
                                name="dokumen_penutupan"
                                accept=".pdf"
                                class="w-full rounded-xl border-green-300 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            >

                            <p class="mt-2 text-xs text-green-700">
                                Upload dokumen tindak lanjut maksimal 5 MB.
                            </p>

                            @error('dokumen_penutupan')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                    </div>
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
                    Simpan Perubahan
                </button>

            </div>
        </form>

    </div>

</div>

<div
    id="modal-konfirmasi-close"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/60 p-4"
>
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

        <div class="flex items-start gap-4">

            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-2xl">
                ⚠️
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Tutup Temuan?
                </h2>

                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                    Anda akan mengubah status temuan
                    <span class="font-bold text-gray-900">
                        {{ $temuan->nomor_temuan }}
                    </span>
                    menjadi Close.
                </p>
            </div>

        </div>

        <div class="mt-5 rounded-xl border border-gray-200 bg-gray-50 p-4">
            <p class="text-sm font-semibold text-gray-800">
                Pastikan:
            </p>

            <div class="mt-3 space-y-2 text-sm text-gray-600">
                <p>✓ Seluruh tindak lanjut telah selesai.</p>
                <p>✓ Seluruh dokumen telah diverifikasi.</p>
                <p>✓ Informasi penutupan telah diisi dengan benar.</p>
            </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <button
                type="button"
                id="tombol-batal-close"
                class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                Batal
            </button>

            <button
                type="button"
                id="tombol-konfirmasi-close"
                class="rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
            >
                Ya, Tutup Temuan
            </button>

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-edit-temuan');
        const statusSelect = document.getElementById('status');

        const bagianPenutupan = document.getElementById('bagian-penutupan');
        const peringatanPenutupan = document.getElementById('peringatan-penutupan');

        const tanggalClose = document.getElementById('tanggal_close');
        const keteranganPenutupan = document.getElementById(
            'keterangan_penutupan'
        );

        const modal = document.getElementById('modal-konfirmasi-close');
        const tombolBatal = document.getElementById('tombol-batal-close');
        const tombolKonfirmasi = document.getElementById(
            'tombol-konfirmasi-close'
        );

        const statusAwal = form.dataset.statusAwal;
        let sudahDikonfirmasi = false;

        function aturBagianPenutupan() {
            const statusClose = statusSelect.value === 'Close';

            bagianPenutupan.classList.toggle('hidden', !statusClose);
            peringatanPenutupan.classList.toggle('hidden', !statusClose);

            tanggalClose.required = statusClose;
            keteranganPenutupan.required = statusClose;
        }

        function bukaModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function tutupModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        statusSelect.addEventListener('change', aturBagianPenutupan);

        form.addEventListener('submit', function (event) {
            const berubahMenjadiClose =
                statusAwal !== 'Close' &&
                statusSelect.value === 'Close';

            if (berubahMenjadiClose && !sudahDikonfirmasi) {
                event.preventDefault();
                bukaModal();
            }
        });

        tombolBatal.addEventListener('click', tutupModal);

        tombolKonfirmasi.addEventListener('click', function () {
            sudahDikonfirmasi = true;
            tutupModal();
            form.requestSubmit();
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                tutupModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                tutupModal();
            }
        });

        aturBagianPenutupan();
    });
</script>
@endsection
