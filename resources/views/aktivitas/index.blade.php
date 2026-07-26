@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')

<div class="p-6 md:p-8">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">
                Riwayat Aktivitas Sistem
            </h1>

            <p class="mt-2 text-slate-500">
                Rekam jejak perubahan data yang dilakukan pengguna SITBA.
            </p>
        </div>

        <div class="rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
            Total {{ $activities->total() }} aktivitas
        </div>

    </div>


    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="divide-y divide-slate-100">

            @forelse ($activities as $activity)

                @php
                    $action = strtolower($activity->action);

                    $badge = match($action) {
                        'create' => [
                            'label' => 'Penambahan Data',
                            'class' => 'bg-emerald-100 text-emerald-700',
                            'icon' => '+'
                        ],
                        'update' => [
                            'label' => 'Perubahan Data',
                            'class' => 'bg-blue-100 text-blue-700',
                            'icon' => '↻'
                        ],
                        'delete' => [
                            'label' => 'Penghapusan Data',
                            'class' => 'bg-red-100 text-red-700',
                            'icon' => '×'
                        ],
                        default => [
                            'label' => ucfirst($activity->action),
                            'class' => 'bg-slate-100 text-slate-700',
                            'icon' => '•'
                        ],
                    };
                @endphp


                <div class="flex gap-4 px-6 py-5">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-2xl text-xl font-black {{ $badge['class'] }}"
                    >
                        {{ $badge['icon'] }}
                    </div>


                    <div class="flex-1">

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">

                            <div>

                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $badge['class'] }}"
                                >
                                    {{ $badge['label'] }}
                                </span>


                                <h3 class="mt-2 text-lg font-bold text-slate-900">
                                    {{ $activity->model }}
                                </h3>


                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $activity->description }}
                                </p>

                            </div>


                            <div class="text-sm text-slate-400">
                                {{ $activity->created_at->format('d M Y, H:i') }}
                            </div>

                        </div>


                        <div class="mt-3 text-xs text-slate-500">
                            Oleh:
                            <span class="font-semibold text-slate-700">
                                {{ $activity->user?->name ?? 'System' }}
                            </span>
                        </div>

                    </div>

                </div>


            @empty

                <div class="px-6 py-10 text-center text-slate-500">
                    Belum ada aktivitas.
                </div>

            @endforelse

        </div>

    </div>


    <div class="mt-6">
        {{ $activities->links() }}
    </div>

</div>

@endsection
