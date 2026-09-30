@props([
    'title' => null,
    'subtitle' => null,
    'class' => '',
])

<div {{ $attributes->class(['card-header', $class]) }}>
    @if (filled($title) || filled($subtitle) || filled($slot))
        <div class="min-w-0">
            @if (filled($title))
                <h3 class="text-base font-semibold text-heading">{{ $title }}</h3>
            @endif

            @if (filled($subtitle))
                <p class="text-xs text-body-subtle mt-0.5">{{ $subtitle }}</p>
            @endif

            {{ $slot }}
        </div>
    @endif

    @isset($actions)
        <div class="flex items-center gap-2 flex-wrap">{{ $actions }}</div>
    @endisset
</div>