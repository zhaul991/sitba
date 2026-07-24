@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Foto Temuan
        </h1>

        <p class="mt-2 text-gray-500">
            Unggah dokumentasi foto sebagai bukti kondisi temuan.
        </p>
    </div>

    <div class="max-w-3xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

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
                    Foto belum dapat disimpan.
                </p>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('fototemuan.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <input
                type="hidden"
                name="temuan_id"
                value="{{ $temuan->id }}"
            >

            <div>
                <label
                    for="foto"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Pilih Foto
                </label>

                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="block w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-700
                           file:mr-4 file:border-0 file:bg-blue-50 file:px-5 file:py-3
                           file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                    required
                >

                <p class="mt-2 text-xs text-gray-500">
                    Format JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 5 MB.
                </p>
            </div>

            <div id="preview-wrapper" class="mt-6 hidden">
                <p class="mb-2 text-sm font-semibold text-gray-700">
                    Pratinjau Foto
                </p>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <img
                        id="preview-image"
                        src=""
                        alt="Pratinjau foto"
                        class="max-h-96 w-full object-contain"
                    >
                </div>
            </div>

            <div class="mt-6">
                <label
                    for="keterangan"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Keterangan Foto
                </label>

                <textarea
                    id="keterangan"
                    name="keterangan"
                    rows="4"
                    placeholder="Contoh: Kondisi kerusakan pada sisi kiri runway..."
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >{{ old('keterangan') }}</textarea>
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
                    Simpan Foto
                </button>

            </div>
        </form>

    </div>

</div>

<script>
    const inputFoto = document.getElementById('foto');
    const previewWrapper = document.getElementById('preview-wrapper');
    const previewImage = document.getElementById('preview-image');

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            previewWrapper.classList.add('hidden');
            previewImage.src = '';
            return;
        }

        previewImage.src = URL.createObjectURL(file);
        previewWrapper.classList.remove('hidden');
    });
</script>
@endsection
