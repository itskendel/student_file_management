@props([
    'type' => 'text',
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'placeholder' => null,
    'value' => null,
    'size' => 'md',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'class' => '',
])

@php
    $sizes = ['sm', 'md', 'lg'];

    $id = $id ?: ($name ? 'input-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name) : 'input-'.uniqid());
    $hasError = filled($error);
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, $hasError ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $currentValue = old($name, $value);
    $hasTrailing = isset($trailing);

    $classes = array_filter([
        'input',
        'input-'.(in_array($size, $sizes, true) ? $size : 'md'),
        $class,
    ]);
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error" :required="$required">
    <div @class([
        'input-group',
        'input-group-end' => $hasTrailing,
    ])>
        @isset($icon)
            <span class="input-group-icon input-group-icon-start">{{ $icon }}</span>
        @endisset

        <input
            {{ $attributes->class($classes) }}
            id="{{ $id }}"
            @if (filled($name)) name="{{ $name }}" @endif
            @if (filled($currentValue)) value="{{ $currentValue }}" @endif
            @if (filled($placeholder)) placeholder="{{ $placeholder }}" @endif
            type="{{ $type }}"
            @required($required)
            @disabled($disabled)
            @readonly($readonly)
            @if ($hasError) aria-invalid="true" @endif
            @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif />

        @isset($trailing)
            <span class="input-group-icon input-group-icon-end">{{ $trailing }}</span>
        @endisset
    </div>
</x-flowbite.field>