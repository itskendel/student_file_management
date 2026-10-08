@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.index')">Students</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('students.show', $student->id)">{{ $student->name }}</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>Upload file</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-xl font-semibold text-heading sm:text-2xl">Upload student file</h1>
                <p class="mt-1 text-sm text-body-subtle">
                    Attach a PDF document to this student's record.
                </p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('students.index')" class="shrink-0">
                Back to list
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form action="{{ route('student.store_file') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 sm:space-y-6" novalidate>
            @csrf

            <input type="hidden" name="student_id" value="{{ old('student_id', $student->id) }}">

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Document details"
                        subtitle="Choose the category of the document and select the file to upload." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4 sm:grid-cols-1">
                        <x-flowbite.select name="file_type_id" label="File type" required :options="$file_types->pluck('name', 'id')->all()"
                            placeholder="Select a file type" helper="The category this document belongs to."
                            :error="$errors->first('file_type_id')" />

                        <x-flowbite.input type="file" name="document" label="Document" required accept="application/pdf"
                            helper="PDF files only." :error="$errors->first('document')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('students.index')">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Upload</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
