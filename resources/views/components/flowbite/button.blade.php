@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'block' => false,
    'iconOnly' => false,
    'class' => '',
])

@php
    $variants = ['primary', 'secondary', 'tertiary', 'ghost', 'success', 'danger', 'warning'];
    $sizes = ['sm', 'md', 'lg'];

    $classes = array_filter([
        'btn',
        'btn-'.(in_array($size, $sizes, true) ? $size : 'md'),
        'btn-'.(in_array($variant, $variants, true) ? $variant : 'primary'),
        $block ? 'btn-block' : null,
        $iconOnly ? 'btn-icon' : null,
        $loading ? 'btn-loading' : null,
        $class,
    ]);

    $isDisabled = (bool) ($disabled || $loading);
@endphp

@if (filled($href))
    <a {{ $attributes->class($classes) }} href="{{ $href }}" @if ($isDisabled) aria-disabled="true" tabindex="-1" @endif>
        @isset($icon)<span class="btn-icon-slot">{{ $icon }}</span>@endisset
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($classes) }} type="{{ $type }}" @disabled($disabled)
        @if ($loading) aria-busy="true" @endif>
        @isset($icon)<span class="btn-icon-slot">{{ $icon }}</span>@endisset
        {{ $slot }}
    </button>
@endif