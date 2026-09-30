@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'value' => null,
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'inline' => true,
    'class' => '',
])

@php
    $id = $id ?: ($name ? 'radio-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name).'-'.uniqid() : 'radio-'.uniqid());
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, filled($error) ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $isChecked = (bool) old($name, $checked);
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error" :required="$required"
    :inline="$inline">
    <input type="radio" {{ $attributes->class(['radio', $class]) }} id="{{ $id }}"
        @if (filled($name)) name="{{ $name }}" @endif
        value="{{ $value ?? ($id) }}" @checked($isChecked)
        @required($required) @disabled($disabled)
        @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif />
</x-flowbite.field>