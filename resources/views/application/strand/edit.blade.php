@extends('layouts.app')

@section('content')
    <div class="mx-auto w-full space-y-4 sm:space-y-6">
        <x-flowbite.breadcrumb label="Breadcrumb">
            <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('strands.index')">Strands</x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item :href="route('strands.show', $strand->id)">{{ $strand->name }}
            </x-flowbite.breadcrumb-item>
            <x-flowbite.breadcrumb-item current>Edit</x-flowbite.breadcrumb-item>
        </x-flowbite.breadcrumb>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-semibold text-heading sm:text-2xl">Edit Strand</h1>
                <p class="mt-1 truncate text-sm text-body-subtle">{{ $strand->name }}</p>
            </div>

            <x-flowbite.button variant="tertiary" :href="route('strands.show', $strand->id)" class="shrink-0">
                Back to details
            </x-flowbite.button>
        </div>

        <x-application.alerts />

        <form method="POST" action="{{ route('strands.update', $strand->id) }}" class="space-y-4 sm:space-y-6" novalidate>
            @csrf
            @method('PUT')

            <x-flowbite.card>
                <x-slot:header>
                    <x-flowbite.card-header title="Details"
                        subtitle="Name and description of the academic strand." />
                </x-slot:header>

                <x-flowbite.card-body>
                    <div class="grid gap-4">
                        <x-flowbite.input name="name" label="Strand Name" :value="$strand->name" required maxlength="255"
                            placeholder="e.g. ICT" :error="$errors->first('name')" />

                        <x-flowbite.textarea name="desc" label="Description" :value="$strand->desc" required rows="4"
                            helper="The full name of the strand, shown wherever the strand is listed."
                            placeholder="e.g. Information and Communication Technology" :error="$errors->first('desc')" />
                    </div>
                </x-flowbite.card-body>
            </x-flowbite.card>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
                <x-flowbite.button variant="tertiary" :href="route('strands.show', $strand->id)">Cancel</x-flowbite.button>
                <x-flowbite.button type="submit">Update strand</x-flowbite.button>
            </div>
        </form>
    </div>
@endsection
