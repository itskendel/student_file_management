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
    'indeterminate' => false,
    'inline' => true,
    'class' => '',
])

@php
    $id = $id ?: ($name ? 'checkbox-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name) : 'checkbox-'.uniqid());
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, filled($error) ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $isChecked = (bool) old($name, $checked);
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error" :required="$required"
    :inline="$inline">
    <input type="checkbox" {{ $attributes->class(['checkbox', $class]) }} id="{{ $id }}"
        @if (filled($name)) name="{{ $name }}" @endif value="1" @checked($isChecked)
        @required($required) @disabled($disabled)
        @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif
        @if ($indeterminate) aria-checked="mixed" @endif />
</x-flowbite.field>