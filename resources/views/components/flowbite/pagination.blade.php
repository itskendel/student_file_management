@props([
    'paginator' => null,
    'onEachSide' => 1,
    'view' => 'pagination::bento',
    'class' => '',
])

<div {{ $attributes->class(['flex justify-center', $class]) }}>
    @if (filled($paginator) && method_exists($paginator, 'links'))
        {{ $paginator->onEachSide($onEachSide)->links($view) }}
    @elseif (trim((string) $slot) !== '')
        {{ $slot }}
    @endif
</div>