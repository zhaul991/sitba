@props([
    'title' => 'Filter Data',
    'description' => null,
])

<div
    {{ $attributes->merge([
        'class' =>
            'overflow-hidden rounded-2xl border ' .
            'border-slate-200 bg-white shadow-sm'
    ]) }}
>
    @if ($title || $description)
        <div
            class="border-b border-slate-200
                   bg-slate-50 px-5 py-4"
        >
            @if ($title)
                <p class="text-sm font-bold text-slate-700">
                    {{ $title }}
                </p>
            @endif

            @if ($description)
                <p class="mt-1 text-xs text-slate-500">
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif

    <div class="p-5">
        {{ $slot }}
    </div>
</div>
