@props([
    'striped' => false,
    'hover' => true,
    'caption' => null,
    'class' => '',
])

<div {{ $attributes->class(['table-wrapper', $class]) }}>
    <table @class(['table', 'table-hover' => $hover, 'table-striped' => $striped])>
        @if (filled($caption))
            <caption class="sr-only">{{ $caption }}</caption>
        @endif

        @isset($header)
            <thead>
                <tr>
                    {{ $header }}
                </tr>
            </thead>
        @endisset

        @isset($body)
            <tbody>
                {{ $body }}
            </tbody>
        @endisset
    </table>
</div>