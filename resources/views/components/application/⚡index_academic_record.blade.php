<?php

use Livewire\Component;
use App\Models\Student;

new class extends Component {
    //
    public Student $student;

    public function mount(Student $student)
    {
        $this->student = $student;
    }
};
?>

<div>
    <x-flowbite.card>
        <x-slot:header>
            <x-flowbite.card-header title="Academic Information"
                subtitle="School year, grade level, strand and section assignments." />
        </x-slot:header>

        @if ($student->academic_records->isEmpty())
            <x-flowbite.card-body>
                <x-flowbite.empty-state title="No academic records"
                    description="This student has no school year, grade level, strand or section assignment yet."
                    class="p-0">
                </x-flowbite.empty-state>
            </x-flowbite.card-body>
        @else
            <x-flowbite.table :hover="true" caption="Academic records">
                <x-slot:header>
                    <x-flowbite.table-header>School Year</x-flowbite.table-header>
                    <x-flowbite.table-header>Grade Level</x-flowbite.table-header>
                    <x-flowbite.table-header>Strand</x-flowbite.table-header>
                    <x-flowbite.table-header>Section</x-flowbite.table-header>
                </x-slot:header>

                <x-slot:body>
                    @foreach ($student->academic_records as $record)
                        <tr>
                            <x-flowbite.table-row>
                                {{ $record->school_year?->name ?? '—' }}
                            </x-flowbite.table-row>
                            <x-flowbite.table-row>
                                {{ $record->grade_level?->name ?? '—' }}
                            </x-flowbite.table-row>
                            <x-flowbite.table-row>
                                {{ $record->strand?->name ?? '—' }}
                            </x-flowbite.table-row>
                            <x-flowbite.table-row>
                                {{ filled($record->section) ? $record->section : '—' }}
                            </x-flowbite.table-row>
                        </tr>
                    @endforeach
                </x-slot:body>
            </x-flowbite.table>
        @endif
    </x-flowbite.card>
</div>
