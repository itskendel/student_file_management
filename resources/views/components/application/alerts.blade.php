@props([
    'class' => ''
])

@php
    $flash = array_filter([
        'success' => session('success'),
        'error' => session('error')
    ]);
@endphp

@if (filled($flash) || $errors->any())
    <div class="space-y-3 {{ $class }}" role="region" aria-label="Notifications">
        @foreach ($flash as $variant => $message)
            <x-flowbite.alert :variant="$variant === 'success' ? 'success' : 'danger'" :title="$variant === 'success' ? 'Success' : 'Something went wrong'" dismissible>
                {{ $message }}
            </x-flowbite.alert>
        @endforeach

        @if ($errors->any())
            <x-flowbite.alert variant="danger" title="Please review the highlighted fields.">
                <ul class="mt-1 space-y-1 list-disc ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-flowbite.alert>
        @endif
    </div>
@endif
