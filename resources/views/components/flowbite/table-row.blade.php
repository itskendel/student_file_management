@props([
    'align' => 'start',
    'class' => '',
])

@php
    $alignClass = match ($align) {
        'center' => 'text-center',
        'end' => 'text-end',
        default => 'text-start',
    };
@endphp

<td {{ $attributes->class([$alignClass, $class]) }}>
    {{ $slot }}
</td>