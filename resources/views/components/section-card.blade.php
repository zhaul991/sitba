@props([
    'title',
    'description' => null,
])

<div
    {{ $attributes->merge([
        'class' =>
            'overflow-hidden rounded-2xl border ' .
            'border-slate-200 bg-white shadow-sm'
    ]) }}
>
    <div class="border-b border-slate-200 px-6 py-5">
        <h2 class="text-lg font-bold text-slate-800">
            {{ $title }}
        </h2>

        @if ($description)
            <p class="mt-1 text-sm text-slate-500">
                {{ $description }}
            </p>
        @endif
    </div>

    {{ $slot }}
</div>
