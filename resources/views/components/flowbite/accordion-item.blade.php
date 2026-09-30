@props([
    'heading' => null,
    'open' => false,
    'headingLevel' => 3,
    'class' => '',
])

@php
    $id = 'accordion-item-'.uniqid();
    $level = in_array((int) $headingLevel, [2, 3, 4, 5, 6], true) ? (int) $headingLevel : 3;
@endphp

<div {{ $attributes->class(['accordion-item', $class]) }} data-accordion-item>
    <h{{ $level }} id="{{ $id }}-heading">
        <button type="button"
            class="accordion-trigger"
            data-accordion-target="#{{ $id }}-body"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $id }}-body">
            <span>{{ $heading }}</span>

            <svg data-accordion-icon class="accordion-icon shrink-0 rtl:rotate-180" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </h{{ $level }}>

    <div id="{{ $id }}-body" class="accordion-body {{ $open ? '' : 'hidden' }}"
        aria-labelledby="{{ $id }}-heading">
        {{ $slot }}
    </div>
</div>