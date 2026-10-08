@extends('layouts.app')

@section('content')
    @php
        $formatDate = fn($value) => filled($value) ? Date::parse($value)->format('M j, Y') : null;

        $name = collect([$student->first_name, $student->middle_name, $student->last_name, $student->suffix])
            ->filter()
            ->join(' ');

        $personal = [
            ['label' => 'Student ID', 'value' => $student->student_id],
            ['label' => 'Learning Reference Number', 'value' => $student->lrn],
            ['label' => 'First Name', 'value' => $student->first_name],
            ['label' => 'Middle Name', 'value' => $student->middle_name],
            ['label' => 'Last Name', 'value' => $student->last_name],
            ['label' => 'Suffix', 'value' => $student->suffix],
            ['label' => 'Birth Date', 'value' => $formatDate($student->birth_date)],
            ['label' => 'Sex', 'value' => $student->sex]
        ];

        $contact = [
            ['label' => 'Email Address', 'value' => $student->email],
            ['label' => 'Phone Number', 'value' => $student->phone_number],
            ['label' => 'Address', 'value' => $student->address]
        ];
    @endphp

    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.index')">Students</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>{{ $name }}</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <x-application.alerts />

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                <x-flowbite.avatar :name="$name" size="xl" />

                <div class="min-w-0">
                    <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">{{ $name }}</h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        @if (filled($student->student_id))
                            <x-flowbite.badge variant="secondary">{{ $student->student_id }}</x-flowbite.badge>
                        @endif
                        @if (filled($student->lrn))
                            <x-flowbite.badge variant="primary">LRN {{ $student->lrn }}</x-flowbite.badge>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex shrink-0 flex-col-reverse gap-2 sm:flex-row sm:items-center">
                <x-flowbite.button variant="tertiary" :href="route('students.index')">
                    Back to list
                </x-flowbite.button>

                <x-flowbite.button :href="route('students.edit', $student->id)">
                    Edit student
                </x-flowbite.button>
            </div>
        </div>

        <div class="grid gap-4 sm:gap-6 lg:grid-cols-2">
            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Personal Information"
                        subtitle="Identification and demographic details." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <dl class="grid gap-x-6 gap-y-4 sm:grid-cols-2">
                        @foreach ($personal as $field)
                            <div class="min-w-0">
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

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Contact Information"
                        subtitle="Channels for reaching the student or their guardian." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <dl class="grid gap-x-6 gap-y-4 sm:grid-cols-2">
                        @foreach ($contact as $field)
                            <div class="min-w-0 {{ $field['label'] === 'Address' ? 'sm:col-span-2' : '' }}">
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
        </div>

        @livewire('application.index_academic_record', ['student' => $student])

        @livewire('application.index_file', ['student' => $student])
    </div>
@endsection
