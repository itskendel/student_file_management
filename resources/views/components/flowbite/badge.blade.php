@props([
    'variant' => 'neutral',
    'size' => 'md',
    'dot' => false,
    'class' => '',
])

@php
    $variants = ['neutral', 'primary', 'secondary', 'success', 'warning', 'danger'];
    $sizes = ['md', 'lg'];

    $classes = array_filter([
        'badge',
        'badge-'.(in_array($variant, $variants, true) ? $variant : 'neutral'),
        in_array($size, $sizes, true) && $size !== 'md' ? 'badge-'.$size : null,
        $class,
    ]);
@endphp

<span {{ $attributes->class($classes) }}>
    @if ($dot)
        <span class="badge-dot" aria-hidden="true"></span>
    @endif

    {{ $slot }}
</span>