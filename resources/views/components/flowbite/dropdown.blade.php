@props([
    'label' => 'Options',
    'id' => null,
    'variant' => 'tertiary',
    'size' => 'sm',
    'iconOnly' => false,
    'placement' => 'bottom-start',
    'align' => 'end',
    'class' => '',
])

@php
    $id = $id ?: 'dropdown-'.uniqid();
@endphp

<div {{ $attributes->class(['dropdown', $class]) }}>
    <button type="button" class="dropdown-trigger btn btn-{{ $variant }} btn-{{ $size }} {{ $iconOnly ? 'btn-icon' : '' }}"
        data-dropdown-toggle="{{ $id }}" data-dropdown-placement="{{ $placement }}" aria-expanded="false"
        aria-haspopup="true">
        @if ($iconOnly)
            {{ $trigger ?? $label }}
            <span class="sr-only">{{ $label }}</span>
        @else
            {{ $label }}
        @endif
    </button>

    <div id="{{ $id }}"
        class="dropdown-menu hidden {{ $align === 'end' ? 'end-0' : 'start-0' }} absolute mt-2 z-30"
        data-dropdown-placement="{{ $placement }}">
        {{ $slot }}
    </div>
</div>