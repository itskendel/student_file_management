@extends('layouts.app')

@section('content')
    @php
        $sexOptions = ['Male', 'Female'];
    @endphp

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

        <form method="POST" action="{{ route('students.store') }}" class="space-y-4 sm:space-y-6" novalidate>
            @csrf

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Personal Information"
                        subtitle="Identification and demographic details of the student." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <x-flowbite.input name="student_id" label="Student ID" maxlength="255"
                            placeholder="e.g. 2026-0001" :error="$errors->first('student_id')" />

                        <x-flowbite.input name="lrn" label="Learning Reference Number (LRN)" maxlength="255"
                            placeholder="e.g. 136728450091" :error="$errors->first('lrn')" />

                        <x-flowbite.input name="first_name" label="First Name" required maxlength="255"
                            autocomplete="given-name" :error="$errors->first('first_name')" />

                        <x-flowbite.input name="middle_name" label="Middle Name" maxlength="255"
                            autocomplete="additional-name" :error="$errors->first('middle_name')" />

                        <x-flowbite.input name="last_name" label="Last Name" required maxlength="255"
                            autocomplete="family-name" :error="$errors->first('last_name')" />

                        <x-flowbite.input name="suffix" label="Suffix" maxlength="50" placeholder="e.g. Jr."
                            :error="$errors->first('suffix')" />

                        <x-flowbite.input name="birth_date" label="Birth Date" type="date" required
                            :max="now()->subDay()->toDateString()" :error="$errors->first('birth_date')" />

                        <x-flowbite.field label="Sex" required for="sex-male" :error="$errors->first('sex')">
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                                @foreach ($sexOptions as $option)
                                    <x-flowbite.radio name="sex" :id="'sex-'.strtolower($option)"
                                        :value="$option" :label="$option" :checked="old('sex') === $option"
                                        :required="$loop->first" :showRequiredMarker="false" />
                                @endforeach
                            </div>
                        </x-flowbite.field>
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Contact Information"
                        subtitle="Optional channels for reaching the student or their guardian." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-flowbite.input name="email" label="Email Address" type="email" maxlength="255"
                            autocomplete="email" placeholder="student@example.com"
                            :error="$errors->first('email')" />

                        <x-flowbite.input name="phone_number" label="Phone Number" type="tel" maxlength="20"
                            autocomplete="tel" placeholder="+63 900 000 0000"
                            :error="$errors->first('phone_number')" />

                        <div class="sm:col-span-2">
                            <x-flowbite.textarea name="address" label="Address" rows="3"
                                :error="$errors->first('address')" />
                        </div>
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

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

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('students.index')">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Create student</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
