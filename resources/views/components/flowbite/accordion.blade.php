@props([
    'id' => null,
    'class' => '',
])

@php
    $id = $id ?: 'accordion-'.uniqid();
@endphp

<div {{ $attributes->class(['accordion', $class]) }} id="{{ $id }}" data-accordion="collapse">
    {{ $slot }}
</div>