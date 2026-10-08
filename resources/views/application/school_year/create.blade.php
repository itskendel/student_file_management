@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('school_years.index')">School Years</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>New school year</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-xl font-semibold text-heading sm:text-2xl">New School Year</h1>
                <p class="mt-1 text-sm text-body-subtle">
                    Add a school year that student records can be assigned to.
                </p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('school_years.index')" class="shrink-0">
                Back to list
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form method="POST" action="{{ route('school_years.store') }}" class="space-y-4 sm:space-y-6" novalidate>
            @csrf

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="School Year Details"
                        subtitle="Name and description of the school year." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4">
                        <x-flowbite.input name="name" label="School Year" required maxlength="255"
                            placeholder="e.g. 2026 - 2027" :error="$errors->first('name')" />

                        <x-flowbite.textarea name="desc" label="Description" required rows="4"
                            helper="The full description of the school year, shown wherever the school year is listed."
                            placeholder="e.g. S.Y. 2026 - 2027" :error="$errors->first('desc')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('school_years.index')">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Create school year</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
