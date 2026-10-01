@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'options' => [],
    'placeholder' => null,
    'selected' => null,
    'size' => 'md',
    'required' => false,
    'disabled' => false,
    'multiple' => false,
    'class' => '',
])

@php
    $sizes = ['sm', 'md', 'lg'];

    $id = $id ?: ($name ? 'select-'.preg_replace('/[^a-zA-Z0-9_-]/', '-', $name) : 'select-'.uniqid());
    $hasError = filled($error);
    $describedBy = collect([filled($helper) ? $id.'-helper' : null, $hasError ? $id.'-error' : null])
        ->filter()
        ->join(' ');
    $currentValue = old($name, $selected);

    $classes = array_filter([
        'input',
        'select',
        'input-'.(in_array($size, $sizes, true) ? $size : 'md'),
        $class,
    ]);

    $useSlot = empty($options) && trim((string) $slot) !== '';
@endphp

<x-flowbite.field :for="$id" :label="$label" :helper="$helper" :error="$error" :required="$required">
    <select
        {{ $attributes->class($classes) }}
        id="{{ $id }}"
        @if (filled($name)) name="{{ $name }}" @endif
        @required($required)
        @disabled($disabled)
        @if ($multiple) multiple @endif
        @if ($hasError) aria-invalid="true" @endif
        @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif>
        @if (filled($placeholder))
            <option value="" @selected(! $multiple && blank($currentValue))>
                {{ $placeholder }}
            </option>
        @endif

        @if ($useSlot)
            {{ $slot }}
        @else
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $currentValue === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif
    </select>
</x-flowbite.field>