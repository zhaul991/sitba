@extends('layouts.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Edit Tindak Lanjut
        </h1>

        <p class="mt-2 text-gray-500">
            Perbarui progres penanganan temuan.
        </p>
    </div>

    <div class="max-w-4xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('tindaklanjut.update', $tindaklanjut) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Rencana Perbaikan
                    </label>

                    <textarea
                        name="rencana_perbaikan"
                        rows="6"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >{{ old('rencana_perbaikan', $tindaklanjut->rencana_perbaikan) }}</textarea>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            PIC / Penanggung Jawab
                        </label>

                        <input
                            type="text"
                            name="pic"
                            value="{{ old('pic', $tindaklanjut->pic) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Batas Waktu
                        </label>

                        <input
                            type="date"
                            name="deadline"
                            value="{{ old('deadline', $tindaklanjut->deadline?->format('Y-m-d') ?? $tindaklanjut->deadline) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                    </div>

                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        @foreach (['Open', 'Dalam Tindak Lanjut', 'Selesai'] as $status)
                            <option
                                value="{{ $status }}"
                                @selected(old('status', $tindaklanjut->status) === $status)
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">
                        Catatan
                    </label>

                    <textarea
                        name="catatan"
                        rows="4"
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('catatan', $tindaklanjut->catatan) }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('temuan.show', $tindaklanjut->temuan_id) }}"
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
@endsection
