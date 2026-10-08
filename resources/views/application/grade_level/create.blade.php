@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('grade_levels.index')">Grade Levels</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>New grade level</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-xl font-semibold text-heading sm:text-2xl">New Grade Level</h1>
                <p class="mt-1 text-sm text-body-subtle">
                    Add a grade level that students can be assigned to.
                </p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('grade_levels.index')" class="shrink-0">
                Back to list
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form method="POST" action="{{ route('grade_levels.store') }}" class="space-y-4 sm:space-y-6" novalidate>
            @csrf

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Grade Level Details"
                        subtitle="Name and description of the grade level." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4">
                        <x-flowbite.input name="name" label="Grade Level" required maxlength="255"
                            placeholder="e.g. 11" :error="$errors->first('name')" />

                        <x-flowbite.textarea name="desc" label="Description" required rows="4"
                            helper="The full description of the grade level, shown wherever the grade level is listed."
                            placeholder="e.g. SHS Grade 11" :error="$errors->first('desc')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('grade_levels.index')">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Create grade level</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
