@props([
    'for' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'required' => false,
    'inline' => false,
    'class' => '',
])

@php
    $hasMeta = filled($label) || filled($helper) || filled($error);
@endphp

@if ($inline)
    @if ($hasMeta)
        <div {{ $attributes->class(['flex items-start gap-3', $class]) }}>
            {{ $slot }}

            <div class="min-w-0">
                @if (filled($label))
                    <label @if ($for) for="{{ $for }}" @endif
                        class="label mb-0 {{ $required ? 'label-required' : '' }}">{{ $label }}</label>
                @endif

                @if (filled($helper))
                    <p @if ($for) id="{{ $for }}-helper" @endif class="helper">{{ $helper }}</p>
                @endif

                @if (filled($error))
                    <p @if ($for) id="{{ $for }}-error" @endif class="error-message">{{ $error }}</p>
                @endif
            </div>
        </div>
    @else
        {{ $slot }}
    @endif
@else
    @if ($hasMeta)
        <div {{ $attributes->class(['w-full', $class]) }}>
            @if (filled($label))
                <label @if ($for) for="{{ $for }}" @endif
                    class="label {{ $required ? 'label-required' : '' }}">{{ $label }}</label>
            @endif

            {{ $slot }}

            @if (filled($helper))
                <p @if ($for) id="{{ $for }}-helper" @endif class="helper">{{ $helper }}</p>
            @endif

            @if (filled($error))
                <p @if ($for) id="{{ $for }}-error" @endif class="error-message">
                    <svg class="w-3.5 h-3.5 flex-none mt-px" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 10a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $error }}
                </p>
            @endif
        </div>
    @else
        {{ $slot }}
    @endif
@endif