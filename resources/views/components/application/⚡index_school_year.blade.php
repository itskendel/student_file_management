<?php

use Livewire\Component;
use App\Services\ConfigurationService;

new class extends Component {
    public function school_years()
    {
        return app(ConfigurationService::class)->index_school_year()->load('academic_records');
    }

    public function destroy(int $id)
    {
        try {
            app(ConfigurationService::class)->destroy_school_year($id);

            session()->flash('success', 'School year data has been deleted.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete school year data.');
        }
    }
};
?>

@php
    $school_years = $this->school_years();
@endphp

<div class="mx-auto w-full space-y-4 sm:space-y-6">
    <x-flowbite.breadcrumb label="Breadcrumb">
        <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
        <x-flowbite.breadcrumb-item current>School Years</x-flowbite.breadcrumb-item>
    </x-flowbite.breadcrumb>

    <x-application.alerts />

    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-heading sm:text-2xl">School Years</h1>
            <p class="mt-1 text-sm text-body-subtle">
                School years and the students assigned to them.
            </p>
        </div>

        <x-flowbite.button :href="route('school_years.create')" class="shrink-0">
            New school year
        </x-flowbite.button>
    </div>

    <div>
        @if ($school_years->isEmpty())
            <x-flowbite.card-body>
                <x-flowbite.empty-state title="No school years yet"
                    description="Create the first school year so student records can be assigned to it." class="p-0">
                    <x-flowbite.button :href="route('school_years.create')">New school year</x-flowbite.button>
                </x-flowbite.empty-state>
            </x-flowbite.card-body>
        @else
            <x-flowbite.table caption="School Years" striped>
                <x-slot:header>
                    <x-flowbite.table-header>School Year</x-flowbite.table-header>
                    <x-flowbite.table-header>Description</x-flowbite.table-header>
                    <x-flowbite.table-header>Students</x-flowbite.table-header>
                    <x-flowbite.table-header align="end">Actions</x-flowbite.table-header>
                </x-slot:header>

                <x-slot:body>
                    @foreach ($school_years as $school_year)
                        <tr wire:key="school-year-{{ $school_year->id }}">
                            <x-flowbite.table-row>
                                <a href="{{ route('school_years.show', $school_year->id) }}"
                                    class="font-medium text-heading hover:underline">{{ ucwords($school_year->name) }}</a>
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ ucfirst($school_year->desc) }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ $school_year->academic_records->pluck('student_id')->unique()->count() }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row align="end">
                                @php
                                    $modal_id = 'modal-delete-school-year-' . $school_year->id;
                                @endphp

                                <div class="flex items-center justify-end gap-2">
                                    <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('school_years.show', $school_year->id)">
                                        View
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('school_years.edit', $school_year->id)">
                                        Edit
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly
                                        data-modal-target="{{ $modal_id }}" data-modal-toggle="{{ $modal_id }}">
                                        Delete
                                    </x-flowbite.button>
                                </div>

                                <x-flowbite.modal id="{{ $modal_id }}" title="Confirmation">
                                    <p>Are you sure you want to delete this school year?</p>

                                    <x-slot:footerSlot>
                                        <div class="flex gap-2">
                                            <x-flowbite.button variant="ghost" type="button"
                                                data-modal-hide="{{ $modal_id }}">
                                                No
                                            </x-flowbite.button>

                                            <form action="{{ route('school_years.destroy', $school_year->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <x-flowbite.button variant="danger" type="submit">
                                                    Yes, continue
                                                </x-flowbite.button>
                                            </form>
                                        </div>
                                    </x-slot:footerSlot>
                                </x-flowbite.modal>
                            </x-flowbite.table-row>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-flowbite.table>
        @endif
    </div>
</div>
