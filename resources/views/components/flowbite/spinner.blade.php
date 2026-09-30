@props([
    'size' => 'md',
    'label' => 'Loading',
    'class' => '',
])

@php
    $sizes = ['sm', 'md', 'lg'];
@endphp

<span {{ $attributes->class(['spinner', 'spinner-'.(in_array($size, $sizes, true) ? $size : 'md'), $class]) }}
    role="status" aria-live="polite">
    <span class="sr-only">{{ $label }}</span>
</span>