<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Services\StudentService;
use App\Services\ConfigurationService;

new class extends Component {
    //
    use WithPagination;

    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'school_year_id', except: '')]
    public string $school_year_id = '';

    #[Url(as: 'grade_level_id', except: '')]
    public string $grade_level_id = '';

    #[Url(as: 'strand_id', except: '')]
    public string $strand_id = '';

    public function students()
    {
        $filters = [
            'grade_level_id' => $this->grade_level_id ?: null,
            'strand_id' => $this->strand_id ?: null,
            'school_year_id' => $this->school_year_id ?: null
        ];

        return app(StudentService::class)->index(10, $this->search ?: null, $filters);
    }

    public function grade_levels()
    {
        return app(ConfigurationService::class)->index_grade_level();
    }

    public function school_years()
    {
        return app(ConfigurationService::class)->index_school_year();
    }

    public function strands()
    {
        return app(ConfigurationService::class)->index_strand();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset('search', 'school_year_id', 'grade_level_id', 'strand_id');
        $this->resetPage();
    }

    public function destroy(int $id)
    {
        try {
            app(StudentService::class)->destroy($id);

            session()->flash('success', 'Student data has been deleted.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to delete student data.');
        }
    }
};
?>

@php
    $students = $this->students();
    $total = $students->total();

    $hasFilters =
        filled($this->search) ||
        filled($this->school_year_id) ||
        filled($this->grade_level_id) ||
        filled($this->strand_id);
@endphp



<div class="mx-auto w-full space-y-4 sm:space-y-6">
    <x-flowbite.breadcrumb label="Breadcrumb">
        <x-flowbite.breadcrumb-item :href="route('app.dashboard')">Dashboard</x-flowbite.breadcrumb-item>
        <x-flowbite.breadcrumb-item current>Students</x-flowbite.breadcrumb-item>
    </x-flowbite.breadcrumb>

    <x-application.alerts />

    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-heading sm:text-2xl">Students</h1>
            <p class="mt-1 text-sm text-body-subtle">
                Manage student records, academic information, and enrollment details.
            </p>
        </div>

        <x-flowbite.button :href="route('students.create')" class="shrink-0">
            New student
        </x-flowbite.button>
    </div>

    {{-- filters and table --}}
    <div class="space-y-3">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-4">
                <x-flowbite.input name="search" label="Search" wire:model.live.debounce.400ms="search"
                    placeholder="Search student: name, id, lrn, or section">
                </x-flowbite.input>
            </div>

            <div class="lg:col-span-3">
                <x-flowbite.select name="school_year_id" label="School Year" wire:model.live="school_year_id"
                    :selected="$this->school_year_id" :options="$this->school_years()->pluck('name', 'id')->all()" placeholder="All school years" />
            </div>

            <div class="lg:col-span-3">
                <x-flowbite.select name="grade_level_id" label="Grade Level" wire:model.live="grade_level_id"
                    :selected="$this->grade_level_id" :options="$this->grade_levels()->pluck('name', 'id')->all()" placeholder="All grade levels" />
            </div>

            <div class="lg:col-span-2">
                <x-flowbite.select name="strand_id" label="Strand" wire:model.live="strand_id" :selected="$this->strand_id"
                    :options="$this->strands()->pluck('name', 'id')->all()" placeholder="All strands" />
            </div>
        </div>

        <div>
            @if ($students->isEmpty())
                <x-flowbite.card-body>
                    <x-flowbite.empty-state class="p-0" :title="$hasFilters ? 'No students match your filters' : 'No students yet'" :description="$hasFilters
                        ? 'Try clearing the search box or widening the strand, grade level and school year filters.'
                        : 'Create the first student record to start building the registry.'">

                        @if ($hasFilters)
                            <x-flowbite.button variant="secondary" size="sm" wire:click="clearFilters">Clear
                                filters</x-flowbite.button>
                        @endif
                    </x-flowbite.empty-state>
                </x-flowbite.card-body>
            @else
                <x-flowbite.table caption="Student Registry" striped class="transition-opacity"
                    wire:loading.class="opacity-50">
                    <x-slot:header>
                        <x-flowbite.table-header>Student</x-flowbite.table-header>
                        <x-flowbite.table-header>Student ID</x-flowbite.table-header>
                        <x-flowbite.table-header>LRN</x-flowbite.table-header>
                        <x-flowbite.table-header>Sex</x-flowbite.table-header>
                        <x-flowbite.table-header>School Year</x-flowbite.table-header>
                        <x-flowbite.table-header>Grade Level</x-flowbite.table-header>
                        <x-flowbite.table-header>Strand</x-flowbite.table-header>
                        <x-flowbite.table-header>Section</x-flowbite.table-header>
                        <x-flowbite.table-header align="end">Actions</x-flowbite.table-header>
                    </x-slot:header>

                    <x-slot:body>
                        @foreach ($students as $student)
                            @php
                                $records = $student->academic_records;
                                $rows = $records
                                    ->when($this->school_year_id, function ($collection) {
                                        return $collection->where('school_year_id', $this->school_year_id);
                                    })
                                    ->when($this->grade_level_id, function ($collection) {
                                        return $collection->where('grade_level_id', $this->grade_level_id);
                                    })
                                    ->when($this->strand_id, function ($collection) {
                                        return $collection->where('strand_id', $this->strand_id);
                                    })
                                    ->values();

                                if ($rows->isEmpty()) {
                                    $rows = collect([null]);
                                }

                                $school_years = $rows->map(fn($record) => $record?->school_year?->name ?? '—')->all();
                                $grade_levels = $rows->map(fn($record) => $record?->grade_level?->name ?? '—')->all();
                                $strands = $rows->map(fn($record) => $record?->strand?->name ?? '—')->all();
                                $sections = $rows
                                    ->map(fn($record) => filled($record?->section) ? $record->section : '—')
                                    ->all();
                            @endphp

                            <tr wire:key="student-{{ $student->id }}">
                                <x-flowbite.table-row>
                                    <div class="flex items-center gap-3 min-w-0">
                                        <x-flowbite.avatar :name="$student->name" size="sm" />

                                        <div class="min-w-0">
                                            <a href="{{ route('students.show', $student->id) }}"
                                                class="block truncate font-medium text-heading hover:underline">{{ $student->name }}</a>
                                            @if (filled($student->email))
                                                <span
                                                    class="block truncate text-xs text-body-subtle">{{ $student->email }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    @if (filled($student->student_id))
                                        <x-flowbite.badge
                                            variant="secondary">{{ $student->student_id }}</x-flowbite.badge>
                                    @else
                                        <span class="text-body-subtle">—</span>
                                    @endif
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    @if (filled($student->lrn))
                                        <span class="font-mono text-xs text-heading">{{ $student->lrn }}</span>
                                    @else
                                        <span class="text-body-subtle">—</span>
                                    @endif
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    @if (filled($student->sex))
                                        <x-flowbite.badge variant="neutral">{{ $student->sex }}</x-flowbite.badge>
                                    @else
                                        <span class="text-body-subtle">—</span>
                                    @endif
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <div class="space-y-1">
                                        @foreach ($school_years as $school_year)
                                            <div>{{ $school_year }}</div>
                                        @endforeach
                                    </div>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <div class="space-y-1">
                                        @foreach ($grade_levels as $grade_level)
                                            <div>{{ $grade_level }}</div>
                                        @endforeach
                                    </div>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <div class="space-y-1">
                                        @foreach ($strands as $strand)
                                            <div>{{ $strand }}</div>
                                        @endforeach
                                    </div>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <div class="space-y-1">
                                        @foreach ($sections as $section)
                                            <div>{{ $section }}</div>
                                        @endforeach
                                    </div>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row align="end">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('students.show', $student->id)">
                                            View
                                        </x-flowbite.button>

                                        <x-flowbite.button variant="ghost" size="sm" iconOnly :href="route('students.edit', $student->id)">
                                            Edit
                                        </x-flowbite.button>

                                        <x-flowbite.button variant="ghost" size="sm" iconOnly
                                            wire:click="destroy({{ $student->id }})"
                                            wire:confirm="Delete the student data of {{ $student->name }}? This action cannot be undone."
                                            wire:loading.attr="disabled" wire:target="destroy({{ $student->id }})">
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

        <div>
            {{ $students->links() }}
        </div>
    </div>
</div>
