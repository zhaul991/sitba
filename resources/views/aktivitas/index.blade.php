@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')

<div class="p-6 md:p-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800">
            Riwayat Aktivitas Sistem
        </h1>

        <p class="mt-2 text-slate-500">
            Rekam jejak perubahan data yang dilakukan pengguna SITBA.
        </p>
    </div>


    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="divide-y divide-slate-100">

            @forelse ($activities as $activity)

                @php
                    $action = strtolower($activity->action);

                    $iconClass = match($action) {
                        'create' => 'bg-emerald-100 text-emerald-700',
                        'update' => 'bg-blue-100 text-blue-700',
                        'delete' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                    };

                    $icon = match($action) {
                        'create' => '+',
                        'update' => '↻',
                        'delete' => '×',
                        default => '•',
                    };
                @endphp


                <div class="flex gap-4 px-6 py-5">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center
                               rounded-2xl font-black {{ $iconClass }}"
                    >
                        {{ $icon }}
                    </div>


                    <div class="flex-1">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                            <div>

                                <h3 class="font-bold text-slate-900">
                                    {{ ucfirst($activity->action) }}
                                    {{ $activity->model }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $activity->description }}
                                </p>

                            </div>


                            <span class="text-xs text-slate-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </span>

                        </div>


                        <p class="mt-2 text-xs text-slate-500">
                            Oleh:
                            {{ $activity->user?->name ?? 'System' }}
                        </p>

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
