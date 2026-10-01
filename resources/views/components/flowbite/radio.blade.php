@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'value' => null,
    'checked' => false,
    'required' => false,
    'showRequiredMarker' => true,
    'disabled' => false,
    'inline' => true,
    'class' => '',
])

@php
    $id = $id ?: ($name ? 'radio-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name).'-'.uniqid() : 'radio-'.uniqid());
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, filled($error) ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $inputValue = (string) ($value ?? $id);
    $old = filled($name) ? old($name) : null;
    $isChecked = $old === null ? (bool) $checked : (string) $old === $inputValue;
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error"
    :required="$required && $showRequiredMarker" :inline="$inline">
    <input type="radio" {{ $attributes->class(['radio', $class]) }} id="{{ $id }}"
        @if (filled($name)) name="{{ $name }}" @endif
        value="{{ $value ?? ($id) }}" @checked($isChecked)
        @required($required) @disabled($disabled)
        @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif />
</x-flowbite.field>