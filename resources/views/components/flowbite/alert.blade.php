@props([
    'variant' => 'info',
    'title' => null,
    'dismissible' => false,
    'id' => null,
    'class' => '',
])

@php
    $variants = ['info', 'success', 'warning', 'danger', 'neutral'];

    $icons = [
        'info' => '<path fill-rule="evenodd" d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />',
        'success' => '<path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L8 12.6l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd" />',
        'warning' => '<path fill-rule="evenodd" d="M8.3 3.1a2 2 0 013.4 0l6 10.4A2 2 0 0116 16.7H4a2 2 0 01-1.7-3.2l6-10.4zM10 7a1 1 0 00-1 1v3a1 1 0 002 0V8a1 1 0 00-1-1zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />',
        'danger' => '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 5a1 1 0 012 0v5a1 1 0 11-2 0V5zm1 11a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />',
        'neutral' => '<path fill-rule="evenodd" d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />',
    ];

    $variant = in_array($variant, $variants, true) ? $variant : 'info';
    $role = $variant === 'danger' || $variant === 'warning' ? 'alert' : 'status';
    $id = $id ?: 'alert-'.uniqid();
@endphp

<div {{ $attributes->class(['alert', 'alert-'.$variant, $class])->merge(['id' => $id]) }} role="{{ $role }}">
    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">{!! $icons[$variant] !!}</svg>

    <div class="min-w-0 flex-1">
        @if (filled($title))
            <p class="alert-title">{{ $title }}</p>
        @endif

        <div @class(['alert-title' => blank($title)])>{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <button type="button" class="alert-dismiss" data-dismiss-target="{{ $id }}" aria-label="Dismiss">
            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M4.28 3.22a.75.75 0 00-1.06 1.06L8.94 10l-5.72 5.72a.75.75 0 101.06 1.06L10 11.06l5.72 5.72a.75.75 0 101.06-1.06L11.06 10l5.72-5.72a.75.75 0 00-1.06-1.06L10 8.94 4.28 3.22z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>