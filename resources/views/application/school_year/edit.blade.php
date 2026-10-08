@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('school_years.index')">School Years</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('school_years.show', $school_year->id)">{{ $school_year->name }}
            </x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>Edit</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">Edit School Year</h1>
                <p class="mt-1 truncate text-sm text-body-subtle">{{ $school_year->name }}</p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('school_years.show', $school_year->id)"
                class="shrink-0">
                Back to details
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form method="POST" action="{{ route('school_years.update', $school_year->id) }}"
            class="space-y-4 sm:space-y-6" novalidate>
            @csrf
            @method('PUT')

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="School Year Details"
                        subtitle="Name and description of the school year." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4">
                        <x-flowbite.input name="name" label="School Year" :value="$school_year->name" required
                            maxlength="255" placeholder="e.g. 2026 - 2027" :error="$errors->first('name')" />

                        <x-flowbite.textarea name="desc" label="Description" :value="$school_year->desc" required
                            rows="4" helper="The full description of the school year, shown wherever the school year is listed."
                            placeholder="e.g. S.Y. 2026 - 2027" :error="$errors->first('desc')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('school_years.show', $school_year->id)">Cancel
                </x-flowbite.button>
                <x-flowbite.button type="submit">Update school year</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
