@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <h4 class="mb-0">➕ Tambah Bandara</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('bandara.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama Bandara
                </label>

                <input
                    type="text"
                    name="nama_bandara"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Kode Bandara
                </label>

                <input
                    type="text"
                    name="kode_bandara"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select">

                    <option value="Aktif">
                        Aktif
                    </option>

                    <option value="Non Aktif">
                        Non Aktif
                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                💾 Simpan

            </button>

            <a href="{{ route('bandara.index') }}"
               class="btn btn-secondary">

                ← Kembali

            </a>

        </form>

    </div>

</div>

@endsection