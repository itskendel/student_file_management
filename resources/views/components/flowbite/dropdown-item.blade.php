@props([
    'href' => null,
    'active' => false,
    'disabled' => false,
    'type' => 'button',
    'class' => '',
])

@php
    $classes = array_filter([
        'dropdown-item',
        $active ? 'dropdown-item-active' : null,
        $class,
    ]);
@endphp

@if (filled($href))
    <a {{ $attributes->class($classes) }} href="{{ $href }}" @if ($active) aria-current="true" @endif
        @if ($disabled) aria-disabled="true" tabindex="-1" @endif>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class($classes) }} type="{{ $type }}" @disabled($disabled)
        @if ($active) aria-current="true" @endif>
        {{ $slot }}
    </button>
@endif