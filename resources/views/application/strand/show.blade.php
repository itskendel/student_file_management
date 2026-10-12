@extends('layouts.app')

@section('content')
    @php
        $formatDate = fn($value) => filled($value) ? Date::parse($value)->format('M j, Y') : null;

        $studentCount = $strand->academic_records->pluck('student_id')->unique()->count();

        $overview = [
            ['label' => 'Strand Name', 'value' => $strand->name, 'full' => false],
            ['label' => 'Assigned Students', 'value' => $studentCount, 'full' => false],
            ['label' => 'Description', 'value' => $strand->desc, 'full' => true],
            ['label' => 'Created', 'value' => $formatDate($strand->created_at), 'full' => false],
            ['label' => 'Last Updated', 'value' => $formatDate($strand->updated_at), 'full' => false]
        ];
    @endphp

    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('strands.index')">Strands</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>{{ $strand->name }}</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <x-application.alerts />

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">{{ $strand->name }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <x-flowbite.badge variant="primary">{{ $studentCount }} assigned students</x-flowbite.badge>
                    <x-flowbite.badge variant="secondary">Created {{ $formatDate($strand->created_at) }}</x-flowbite.badge>
                </div>
            </div>

            <div class="flex shrink-0 flex-col-reverse gap-2 sm:flex-row sm:items-center">
                <x-flowbite.button variant="tertiary" :href="route('strands.index')">
                    Back to list
                </x-flowbite.button>

                <x-flowbite.button :href="route('strands.edit', $strand->id)">
                    Edit strand
                </x-flowbite.button>
            </div>
        </div>

        <div class="grid gap-4 sm:gap-6">
            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Overview" subtitle="Strand details and record counts." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <dl class="grid gap-x-6 gap-y-4 sm:grid-cols-2">
                        @foreach ($overview as $field)
                            <div class="min-w-0 {{ $field['full'] ? 'sm:col-span-2' : '' }}">
                                <dt class="text-xs text-body-subtle">{{ $field['label'] }}</dt>
                                <dd class="mt-1 text-sm break-words text-heading">
                                    @if (filled($field['value']))
                                        {{ $field['value'] }}
                                    @else
                                        <x-flowbite.badge variant="neutral">Not provided</x-flowbite.badge>
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </x-flowbite.card-body>
            </x-flowbite.card>

            @livewire('application.show_student', ['strand_id' => (string) $strand->id])
        </div>

        @livewire('application.show_audit', ['model' => 'Strand', 'model_id' => $strand->id])
    </div>
@endsection
