@props([
    'label' => 'Breadcrumb',
    'class' => '',
])

<nav {{ $attributes->class(['w-full', $class]) }} aria-label="{{ $label }}">
    <ol class="breadcrumb-list">
        {{ $slot }}
    </ol>
</nav>