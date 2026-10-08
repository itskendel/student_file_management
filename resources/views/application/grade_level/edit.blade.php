@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('grade_levels.index')">Grade Levels</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('grade_levels.show', $grade_level->id)">{{ $grade_level->name }}
            </x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>Edit</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">Edit Grade Level</h1>
                <p class="mt-1 truncate text-sm text-body-subtle">{{ $grade_level->name }}</p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('grade_levels.show', $grade_level->id)"
                class="shrink-0">
                Back to details
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form method="POST" action="{{ route('grade_levels.update', $grade_level->id) }}"
            class="space-y-4 sm:space-y-6" novalidate>
            @csrf
            @method('PUT')

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Grade Level Details"
                        subtitle="Name and description of the grade level." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4">
                        <x-flowbite.input name="name" label="Grade Level" :value="$grade_level->name" required
                            maxlength="255" placeholder="e.g. 11" :error="$errors->first('name')" />

                        <x-flowbite.textarea name="desc" label="Description" :value="$grade_level->desc" required
                            rows="4" helper="The full description of the grade level, shown wherever the grade level is listed."
                            placeholder="e.g. SHS Grade 11" :error="$errors->first('desc')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('grade_levels.show', $grade_level->id)">Cancel
                </x-flowbite.button>
                <x-flowbite.button type="submit">Update grade level</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
