@props([
    'padding' => false,
    'class' => '',
])

<div {{ $attributes->class(['card', $class]) }}>
    @isset($header)
        {{ $header }}
    @endisset

    @if ($padding)
        <div class="card-body">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    @isset($footer)
        {{ $footer }}
    @endisset
</div>
