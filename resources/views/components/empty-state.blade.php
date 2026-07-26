@props([
    'title' => 'Belum ada data',
    'description' => null,
    'icon' => '🔍',
])

<div
    {{ $attributes->merge([
        'class' => 'px-6 py-12 text-center'
    ]) }}
>
    <div class="text-4xl">
        {{ $icon }}
    </div>

    <p class="mt-3 font-semibold text-slate-700">
        {{ $title }}
    </p>

    @if ($description)
        <p class="mt-1 text-sm text-slate-500">
            {{ $description }}
        </p>
    @endif
</div>
