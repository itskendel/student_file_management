@extends('layouts.app')

@section('content')
    @php
        $birthDate = $student->birth_date;
        $birthDate = $birthDate instanceof DateTimeInterface ? $birthDate->format('Y-m-d') : $birthDate;

        $sexOptions = ['Male', 'Female'];
    @endphp

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

        <form method="POST" action="{{ route('students.update', $student->id) }}" class="space-y-4 sm:space-y-6"
            novalidate>
            @csrf
            @method('PUT')

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Personal Information"
                        subtitle="Identification and demographic details of the student." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <x-flowbite.input name="student_id" label="Student ID" :value="$student->student_id"
                            :error="$errors->first('student_id')" maxlength="255" placeholder="e.g. 2026-0001" />

                        <x-flowbite.input name="lrn" label="Learning Reference Number (LRN)" :value="$student->lrn"
                            :error="$errors->first('lrn')" maxlength="255" placeholder="e.g. 136728450091" />

                        <x-flowbite.input name="first_name" label="First Name" :value="$student->first_name" required
                            maxlength="255" autocomplete="given-name" :error="$errors->first('first_name')" />

                        <x-flowbite.input name="middle_name" label="Middle Name" :value="$student->middle_name"
                            maxlength="255" autocomplete="additional-name" :error="$errors->first('middle_name')" />

                        <x-flowbite.input name="last_name" label="Last Name" :value="$student->last_name" required
                            maxlength="255" autocomplete="family-name" :error="$errors->first('last_name')" />

                        <x-flowbite.input name="suffix" label="Suffix" :value="$student->suffix" maxlength="50"
                            placeholder="e.g. Jr." :error="$errors->first('suffix')" />

                        <x-flowbite.input name="birth_date" label="Birth Date" type="date" :value="$birthDate" required
                            :max="now()->subDay()->toDateString()" :error="$errors->first('birth_date')" />

                        <x-flowbite.field label="Sex" required for="sex-male" :error="$errors->first('sex')">
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                                @foreach ($sexOptions as $option)
                                    <x-flowbite.radio name="sex" :id="'sex-'.strtolower($option)"
                                        :value="$option" :label="$option"
                                        :checked="old('sex', $student->sex) === $option" :required="$loop->first"
                                        :showRequiredMarker="false" />
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
                        <x-flowbite.input name="email" label="Email Address" type="email" :value="$student->email"
                            maxlength="255" autocomplete="email" placeholder="student@example.com"
                            :error="$errors->first('email')" />

                        <x-flowbite.input name="phone_number" label="Phone Number" type="tel"
                            :value="$student->phone_number" maxlength="20" autocomplete="tel"
                            placeholder="+63 900 000 0000" :error="$errors->first('phone_number')" />

                        <div class="sm:col-span-2">
                            <x-flowbite.textarea name="address" label="Address" :value="$student->address" rows="3"
                                :error="$errors->first('address')" />
                        </div>
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('students.show', $student->id)">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Update student</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
