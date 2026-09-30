@props([
    'src' => null,
    'alt' => null,
    'name' => null,
    'size' => 'md',
    'status' => false,
    'class' => '',
])

@php
    $sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
    $initials = collect(preg_split('/\s+/', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY))
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');

    $classes = array_filter([
        'avatar',
        'avatar-'.(in_array($size, $sizes, true) ? $size : 'md'),
        $class,
    ]);
@endphp

<span {{ $attributes->class($classes) }}>
    @if (filled($src))
        <img src="{{ $src }}" alt="{{ $alt ?? $name ?? '' }}" loading="lazy" />
    @else
        <span aria-hidden="true">{{ $initials }}</span>
        @if (filled($name))
            <span class="sr-only">{{ $name }}</span>
        @endif
    @endif

    @if ($status)
        <span class="avatar-status"></span>
        <span class="sr-only">Online</span>
    @endif
</span>