@props([
    'title' => 'Nothing here yet',
    'description' => null,
    'class' => '',
])

<div {{ $attributes->class(['empty-state', $class]) }}>
    @isset($icon)
        <span class="empty-state-icon">{{ $icon }}</span>
    @endisset

    <p class="empty-state-title">{{ $title }}</p>

    @if (filled($description))
        <p class="empty-state-description">{{ $description }}</p>
    @endif

    @if (trim((string) $slot) !== '')
        <div class="flex items-center gap-2 flex-wrap justify-center mt-1">{{ $slot }}</div>
    @endif
</div>