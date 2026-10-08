<?php

use Livewire\Component;
use App\Services\ConfigurationService;

new class extends Component {
    public function grade_levels()
    {
        return app(ConfigurationService::class)->index_grade_level()->load('academic_records');
    }

    public function destroy(int $id)
    {
        try {
            app(ConfigurationService::class)->destroy_grade_level($id);

            session()->flash('success', 'Grade level data has been deleted.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete grade level data.');
        }
    }
};
?>

@php
    $grade_levels = $this->grade_levels();
@endphp

<div class="mx-auto w-full space-y-4 sm:space-y-6">
    <x-flowbite.breadcrumb label="Breadcrumb">
        <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
        <x-flowbite.breadcrumb-item current>Grade Levels</x-flowbite.breadcrumb-item>
    </x-flowbite.breadcrumb>

    <x-application.alerts />

    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-heading sm:text-2xl">Grade Levels</h1>
            <p class="mt-1 text-sm text-body-subtle">
                Grade levels and the students assigned to them.
            </p>
        </div>

        <x-flowbite.button :href="route('grade_levels.create')" class="shrink-0">
            New grade level
        </x-flowbite.button>
    </div>

    <div>
        @if ($grade_levels->isEmpty())
            <x-flowbite.card-body>
                <x-flowbite.empty-state title="No grade levels yet"
                    description="Create the first grade level so students can be assigned to it."
                    class="p-0">
                    <x-flowbite.button :href="route('grade_levels.create')">New grade level</x-flowbite.button>
                </x-flowbite.empty-state>
            </x-flowbite.card-body>
        @else
            <x-flowbite.table caption="Grade Levels" striped>
                <x-slot:header>
                    <x-flowbite.table-header>Grade Level</x-flowbite.table-header>
                    <x-flowbite.table-header>Description</x-flowbite.table-header>
                    <x-flowbite.table-header>Students</x-flowbite.table-header>
                    <x-flowbite.table-header align="end">Actions</x-flowbite.table-header>
                </x-slot:header>

                <x-slot:body>
                    @foreach ($grade_levels as $grade_level)
                        <tr wire:key="grade-level-{{ $grade_level->id }}">
                            <x-flowbite.table-row>
                                <a href="{{ route('grade_levels.show', $grade_level->id) }}"
                                    class="font-medium text-heading hover:underline">{{ ucwords($grade_level->name) }}</a>
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ ucfirst($grade_level->desc) }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ $grade_level->academic_records->pluck('student_id')->unique()->count() }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row align="end">
                                <div class="flex items-center justify-end gap-2">
                                    <x-flowbite.button variant="ghost" size="sm" iconOnly
                                        :href="route('grade_levels.show', $grade_level->id)">
                                        View
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly
                                        :href="route('grade_levels.edit', $grade_level->id)">
                                        Edit
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly
                                        wire:click="destroy({{ $grade_level->id }})"
                                        wire:confirm="Delete the {{ $grade_level->desc }} grade level? This action cannot be undone."
                                        wire:loading.attr="disabled" wire:target="destroy({{ $grade_level->id }})">
                                        Delete
                                    </x-flowbite.button>
                                </div>
                            </x-flowbite.table-row>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-flowbite.table>
        @endif
    </div>
</div>
