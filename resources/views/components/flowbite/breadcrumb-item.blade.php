@props([
    'href' => null,
    'current' => false,
    'class' => '',
])

<li class="breadcrumb-item">
    @if ($current)
        <span class="breadcrumb-current" aria-current="page">
            {{ $slot }}
        </span>
    @else
        <a href="{{ $href ?? '#' }}" {{ $attributes->class(['breadcrumb-link', $class]) }}>
            {{ $slot }}
        </a>
    @endif
</li>

@if (! $current)
    <li class="breadcrumb-item" aria-hidden="true">
        <svg class="breadcrumb-separator w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M7.21 14.77a.75.75 0 01.02-1.06L11.17 10 7.23 6.29a.75.75 0 111.04-1.06l4.5 4.24a.75.75 0 010 1.06l-4.5 4.24a.75.75 0 01-1.06-.02z"
                clip-rule="evenodd" />
        </svg>
    </li>
@endif