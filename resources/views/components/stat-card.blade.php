@props([
    'label',
    'value',
    'tone' => 'default',
    'icon' => null,
])

@php
    $tones = [
        'default' => [
            'wrapper' => 'border-slate-200 bg-gradient-to-br from-white to-slate-50',
            'accent' => 'from-slate-500 to-slate-700',
            'label' => 'text-slate-500',
            'value' => 'text-slate-900',
            'icon' => 'bg-slate-100 text-slate-700 ring-slate-200',
            'glow' => 'bg-slate-300/20',
        ],

        'blue' => [
            'wrapper' => 'border-blue-200 bg-gradient-to-br from-white to-blue-50',
            'accent' => 'from-blue-500 to-blue-700',
            'label' => 'text-blue-700',
            'value' => 'text-blue-950',
            'icon' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'glow' => 'bg-blue-400/20',
        ],

        'indigo' => [
            'wrapper' => 'border-indigo-200 bg-gradient-to-br from-white to-indigo-50',
            'accent' => 'from-indigo-500 to-indigo-700',
            'label' => 'text-indigo-700',
            'value' => 'text-indigo-950',
            'icon' => 'bg-indigo-100 text-indigo-700 ring-indigo-200',
            'glow' => 'bg-indigo-400/20',
        ],

        'cyan' => [
            'wrapper' => 'border-cyan-200 bg-gradient-to-br from-white to-cyan-50',
            'accent' => 'from-cyan-500 to-sky-600',
            'label' => 'text-cyan-700',
            'value' => 'text-cyan-950',
            'icon' => 'bg-cyan-100 text-cyan-700 ring-cyan-200',
            'glow' => 'bg-cyan-400/20',
        ],

        'amber' => [
            'wrapper' => 'border-amber-200 bg-gradient-to-br from-white to-amber-50',
            'accent' => 'from-amber-400 to-orange-600',
            'label' => 'text-amber-700',
            'value' => 'text-amber-950',
            'icon' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'glow' => 'bg-amber-400/20',
        ],

        'green' => [
            'wrapper' => 'border-emerald-200 bg-gradient-to-br from-white to-emerald-50',
            'accent' => 'from-emerald-500 to-green-700',
            'label' => 'text-emerald-700',
            'value' => 'text-emerald-950',
            'icon' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'glow' => 'bg-emerald-400/20',
        ],

        'emerald' => [
            'wrapper' => 'border-emerald-200 bg-gradient-to-br from-white to-emerald-50',
            'accent' => 'from-emerald-500 to-teal-700',
            'label' => 'text-emerald-700',
            'value' => 'text-emerald-950',
            'icon' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'glow' => 'bg-emerald-400/20',
        ],

        'red' => [
            'wrapper' => 'border-red-200 bg-gradient-to-br from-white to-red-50',
            'accent' => 'from-red-500 to-rose-700',
            'label' => 'text-red-700',
            'value' => 'text-red-950',
            'icon' => 'bg-red-100 text-red-700 ring-red-200',
            'glow' => 'bg-red-400/20',
        ],
    ];

    $style = $tones[$tone] ?? $tones['default'];
@endphp

<div
    {{ $attributes->merge([
        'class' =>
            'group relative overflow-hidden rounded-2xl border p-5 ' .
            'shadow-sm transition duration-300 ease-out ' .
            'hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/10 ' .
            $style['wrapper']
    ]) }}
>
    {{-- Aksen warna bagian atas --}}
    <div
        class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r
               {{ $style['accent'] }}"
    ></div>

    {{-- Efek cahaya dekoratif --}}
    <div
        class="pointer-events-none absolute -right-8 -top-8 h-24 w-24
               rounded-full blur-2xl transition duration-300
               group-hover:scale-125 {{ $style['glow'] }}"
    ></div>

    <div class="relative flex items-start justify-between gap-4">

        <div class="min-w-0">

            <p
                class="text-xs font-bold uppercase tracking-[0.12em]
                       {{ $style['label'] }}"
            >
                {{ $label }}
            </p>

            <p
                class="mt-3 text-3xl font-black tracking-tight
                       tabular-nums {{ $style['value'] }}"
            >
                {{ $value }}
            </p>

            <div
                class="mt-4 h-1 w-10 rounded-full bg-gradient-to-r
                       transition-all duration-300 group-hover:w-16
                       {{ $style['accent'] }}"
            ></div>

        </div>

        @if ($icon)

            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center
                       rounded-2xl text-xl shadow-sm ring-1
                       transition duration-300
                       group-hover:scale-110 group-hover:-rotate-3
                       {{ $style['icon'] }}"
            >
                {{ $icon }}
            </div>

        @endif

    </div>
</div>
