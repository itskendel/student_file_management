@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.index')">Students</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.show', $student->id)">{{ $student->name }}
            </x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>Edit</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-center gap-4">
                <x-flowbite.avatar :name="$student->name" size="lg" />

                <div class="min-w-0">
                    <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">Edit Student</h1>
                    <p class="mt-1 truncate text-sm text-body-subtle">{{ $student->name }}</p>
                </div>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('students.show', $student->id)" class="shrink-0">
                Back to profile
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <x-application.student.form :student="$student" :action="route('students.update', $student->id)" method="PUT" :cancel="route('students.show', $student->id)"
            submit="Update student" />
    </div>
@endsection
