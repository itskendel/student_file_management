@props([
    'id' => null,
    'title' => null,
    'size' => 'md',
    'footer' => true,
    'class' => '',
])

@php
    $sizes = ['sm', 'md', 'lg', 'xl'];

    $id = $id ?: 'modal-'.uniqid();
    $sizeClass = 'modal-'.(in_array($size, $sizes, true) ? $size : 'md');
@endphp

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    {{ $attributes->class(['modal hidden', $sizeClass, $class]) }}
    @if (filled($title)) aria-labelledby="{{ $id }}-title" @endif>
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="modal-panel">
            @if (filled($title) || isset($header))
                <div class="modal-header">
                    <h3 class="modal-title" id="{{ $id }}-title">
                        {{ isset($header) ? $header : $title }}
                    </h3>

                    <button type="button" class="modal-close" data-modal-hide="{{ $id }}" aria-label="Close">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M4.28 3.22a.75.75 0 00-1.06 1.06L8.94 10l-5.72 5.72a.75.75 0 101.06 1.06L10 11.06l5.72 5.72a.75.75 0 101.06-1.06L11.06 10l5.72-5.72a.75.75 0 00-1.06-1.06L10 8.94 4.28 3.22z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            @if ($footer && isset($footerSlot) && trim((string) $footerSlot) !== '')
                <div class="modal-footer">
                    {{ $footerSlot }}
                </div>
            @endif
        </div>
    </div>
</div>