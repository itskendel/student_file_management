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

<th scope="col" {{ $attributes->class(['font-semibold', $alignClass, $class]) }}>
    {{ $slot }}
</th>