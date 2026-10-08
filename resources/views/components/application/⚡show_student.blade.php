<?php

use Livewire\Component;
use App\Services\StudentService;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public array $filter = [];
    public string $search = '';

    public function mount(string $strand_id = '', string $school_year_id = '', string $grade_level_id = '')
    {
        $this->filter = [
            'strand_id' => $strand_id ?: null,
            'school_year_id' => $school_year_id ?: null,
            'grade_level_id' => $grade_level_id ?: null
        ];
    }

    public function students()
    {
        return app(StudentService::class)->index(5, $this->search ?: null, $this->filter);
    }

    public function updated(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function title()
    {
        return match (true) {
            filled($this->filter['strand_id']) => 'strand',
            filled($this->filter['school_year_id']) => 'school year',
            default => 'grade level'
        };
    }
};
?>

@php
    $students = $this->students();
    $title = $this->title;
@endphp

<div class="">
    <x-flowbite.card>
        <x-flowbite.card-header title="Student Assignments"
            subtitle="Students currently assigned to this {{ $title }}.">
            <x-slot:actions>
                <x-flowbite.input type="text" wire:model.live.debounce.400ms="search"
                    placeholder="Search student name or id number."></x-flowbite.input>
            </x-slot:actions>
        </x-flowbite.card-header>
        {{-- <x-slot:header>
            <x-flowbite.card-header title="Student Assignments"
                subtitle="Students currently assigned to this {{ $title }}." />
        </x-slot:header> --}}

        @if ($students->isEmpty())
            <x-flowbite.card-body>
                <x-flowbite.empty-state title="No assigned students"
                    description="No student has been assigned to this {{ $title }} yet." class="p-0">
                </x-flowbite.empty-state>
            </x-flowbite.card-body>
        @else
            <div>
                <x-flowbite.table :hover="true" caption="Student assignments to {{ $title }}" striped class="transition-opacity"
                    wire:loading.class="opacity-50">
                    <x-slot:header>
                        <x-flowbite.table-header>Student</x-flowbite.table-header>
                        <x-flowbite.table-header>Student Number</x-flowbite.table-header>
                        <x-flowbite.table-header>Action</x-flowbite.table-header>
                    </x-slot:header>

                    <x-slot:body>
                        @foreach ($students as $student)
                            <tr>
                                <x-flowbite.table-row>
                                    {{ $student->name ?? '-' }}
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    {{ $student->student_id ?? '-' }}
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <x-flowbite.button variant="ghost" size="sm" :href="route('students.show', $student->id)">
                                        view
                                    </x-flowbite.button>
                                </x-flowbite.table-row>
                            </tr>
                        @endforeach
                    </x-slot:body>
                </x-flowbite.table>

                <div class="p-4">
                    {{ $students->links() }}
                </div>
            </div>
        @endif
    </x-flowbite.card>
</div>
