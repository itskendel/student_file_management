<?php

use Livewire\Component;
use App\Services\ConfigurationService;

new class extends Component {
    public function strands()
    {
        return app(ConfigurationService::class)->index_strand()->load('academic_records');
    }

    public function destroy(int $id)
    {
        try {
            app(ConfigurationService::class)->destroy_strand($id);

            session()->flash('success', 'Strand data has been deleted.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete strand data.');
        }
    }
};
?>

@php
    $strands = $this->strands();
@endphp

<div class="mx-auto w-full space-y-4 sm:space-y-6">
    <x-flowbite.breadcrumb label="Breadcrumb">
        <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
        <x-flowbite.breadcrumb-item current>Strands</x-flowbite.breadcrumb-item>
    </x-flowbite.breadcrumb>

    <x-application.alerts />

    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-heading sm:text-2xl">Strands</h1>
            <p class="mt-1 text-sm text-body-subtle">
                Academic strands and the students assigned to them.
            </p>
        </div>

        <x-flowbite.button :href="route('strands.create')" class="shrink-0">
            New strand
        </x-flowbite.button>
    </div>

    <div>
        @if ($strands->isEmpty())
            <x-flowbite.card-body>
                <x-flowbite.empty-state title="No strands yet"
                    description="Create the first strand so students can be assigned to an academic track."
                    class="p-0">
                    <x-flowbite.button :href="route('strands.create')">New strand</x-flowbite.button>
                </x-flowbite.empty-state>
            </x-flowbite.card-body>
        @else
            <x-flowbite.table caption="Strands" striped>
                <x-slot:header>
                    <x-flowbite.table-header>Strand</x-flowbite.table-header>
                    <x-flowbite.table-header>Description</x-flowbite.table-header>
                    <x-flowbite.table-header>Students</x-flowbite.table-header>
                    <x-flowbite.table-header align="end">Actions</x-flowbite.table-header>
                </x-slot:header>

                <x-slot:body>
                    @foreach ($strands as $strand)
                        <tr wire:key="strand-{{ $strand->id }}">
                            <x-flowbite.table-row>
                                <a href="{{ route('strands.show', $strand->id) }}"
                                    class="font-medium text-heading hover:underline">{{ ucwords($strand->name) }}</a>
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ ucfirst($strand->desc) }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row>
                                {{ $strand->academic_records->pluck('student_id')->unique()->count() }}
                            </x-flowbite.table-row>

                            <x-flowbite.table-row align="end">
                                <div class="flex items-center justify-end gap-2">
                                    <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('strands.show', $strand->id)">
                                        View
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('strands.edit', $strand->id)">
                                        Edit
                                    </x-flowbite.button>

                                    <x-flowbite.button variant="ghost" size="sm" iconOnly
                                        wire:click="destroy({{ $strand->id }})"
                                        wire:confirm="Delete the {{ $strand->name }} strand? This action cannot be undone."
                                        wire:loading.attr="disabled" wire:target="destroy({{ $strand->id }})">
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
