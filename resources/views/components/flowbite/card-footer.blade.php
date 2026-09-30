@props([
    'class' => '',
])

<div {{ $attributes->class(['card-footer', $class]) }}>
    {{ $slot }}
</div>