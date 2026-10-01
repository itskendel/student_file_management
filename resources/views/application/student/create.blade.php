@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.index')">Students</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>New student</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-xl font-semibold text-heading sm:text-2xl">New Student</h1>
                <p class="mt-1 text-sm text-body-subtle">
                    Register a student and record their initial academic assignment.
                </p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('students.index')" class="shrink-0">
                Back to list
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <x-application.student.form :action="route('students.store')" :cancel="route('students.index')"
            submit="Create student">
            <x-slot:sections>
                <x-flowbite.card>
                    <x-slot:header>
                        <x-flowbite.card-header title="Academic Information"
                            subtitle="The first academic record attached to this student." />
                    </x-slot:header>

                    <x-flowbite.card-body>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <x-flowbite.select name="school_year_id" label="School Year" required
                                :options="$school_years->pluck('name', 'id')->all()"
                                placeholder="Select a school year" :error="$errors->first('school_year_id')" />

                            <x-flowbite.select name="grade_level_id" label="Grade Level" required
                                :options="$grade_levels->pluck('name', 'id')->all()"
                                placeholder="Select a grade level" :error="$errors->first('grade_level_id')" />

                            <x-flowbite.select name="strand_id" label="Strand" required
                                :options="$strands->pluck('name', 'id')->all()" placeholder="Select a strand"
                                :error="$errors->first('strand_id')" />

                            <x-flowbite.input name="section" label="Section" required maxlength="255"
                                placeholder="e.g. STEM-11A" :error="$errors->first('section')" />
                        </div>
                    </x-flowbite.card-body>
                </x-flowbite.card>
            </x-slot:sections>
        </x-application.student.form>
    </div>
@endsection
