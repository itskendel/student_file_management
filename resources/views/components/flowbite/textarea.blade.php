@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'rows' => 4,
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

    $id = $id ?: ($name ? 'textarea-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name) : 'textarea-'.uniqid());
    $hasError = filled($error);
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, $hasError ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $currentValue = old($name, $value);

    $classes = array_filter([
        'input',
        'textarea',
        'input-'.(in_array($size, $sizes, true) ? $size : 'md'),
        $class,
    ]);
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error" :required="$required">
    <textarea
        {{ $attributes->class($classes) }}
        id="{{ $id }}"
        @if (filled($name)) name="{{ $name }}" @endif
        rows="{{ $rows }}"
        @if (filled($placeholder)) placeholder="{{ $placeholder }}" @endif
        @required($required)
        @disabled($disabled)
        @readonly($readonly)
        @if ($hasError) aria-invalid="true" @endif
        @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif>{{ $currentValue }}</textarea>
</x-flowbite.field>