<?php

use App\Services\StudentService;
use Livewire\Component;

new class extends Component {
    public function analytics()
    {
        return app(StudentService::class)->analytics();
    }
};
?>

@php
    $analytics = $this->analytics();

    $totals = $analytics['totals'];
    $school_year = collect($analytics['per_school_year']);
    $strand = collect($analytics['per_strand']);
    $grade_level = collect($analytics['per_grade_level']);
    $sex = collect($analytics['per_sex']);
@endphp

<div class="mx-auto w-full space-y-4 sm:space-y-6">
    <div>
        <h1 class="text-xl font-semibold text-heading sm:text-2xl">Dashboard</h1>
        <p class="mt-1 text-sm text-body-subtle">
            Enrollment analytics at a glance, plus shortcuts into every module.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-flowbite.card :padding="true">
            <div class="flex flex-col gap-1">
                <span class="text-sm text-body-subtle">Students</span>
                <span class="text-2xl font-semibold text-heading">{{ number_format($totals['students']) }}</span>
            </div>
        </x-flowbite.card>

        <x-flowbite.card :padding="true">
            <div class="flex flex-col gap-1">
                <span class="text-sm text-body-subtle">Enrollments</span>
                <span class="text-2xl font-semibold text-heading">{{ number_format($totals['enrollments']) }}</span>
            </div>
        </x-flowbite.card>

        <x-flowbite.card :padding="true">
            <div class="flex flex-col gap-1">
                <span class="text-sm text-body-subtle">Strands</span>
                <span class="text-2xl font-semibold text-heading">{{ number_format($totals['strands']) }}</span>
            </div>
        </x-flowbite.card>

        <x-flowbite.card :padding="true">
            <div class="flex flex-col gap-1">
                <span class="text-sm text-body-subtle">Documents</span>
                <span class="text-2xl font-semibold text-heading">{{ number_format($totals['documents']) }}</span>
            </div>
        </x-flowbite.card>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-flowbite.card class="lg:col-span-2">
            <x-slot name="header">
                <div class="min-w-0 p-4">
                    <h2 class="text-base font-semibold text-heading">Students per school year</h2>
                    <p class="mt-1 text-sm text-body-subtle">
                        Distinct enrolled students for each school year.
                    </p>
                </div>
            </x-slot>
            <div class="card-body">
                <div class="relative h-64" wire:ignore>
                    <canvas id="chart-students-school-year" role="img"
                        aria-label="Bar chart of distinct students enrolled per school year"></canvas>
                </div>
            </div>
        </x-flowbite.card>

        <x-flowbite.card>
            <x-slot name="header">
                <div class="min-w-0 p-4">
                    <h2 class="text-base font-semibold text-heading">Students per strand</h2>
                    <p class="mt-1 text-sm text-body-subtle">
                        Enrollment share across academic strands.
                    </p>
                </div>
            </x-slot>
            <div class="card-body">
                <div class="relative h-64" wire:ignore>
                    <canvas id="chart-students-strand" role="img"
                        aria-label="Doughnut chart of students per strand"></canvas>
                </div>
            </div>
        </x-flowbite.card>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-flowbite.card class="lg:col-span-2">
            <x-slot name="header">
                <div class="min-w-0 p-4">
                    <h2 class="text-base font-semibold text-heading">Students per grade level</h2>
                    <p class="mt-1 text-sm text-body-subtle">
                        Distinct enrolled students for each grade level.
                    </p>
                </div>
            </x-slot>
            <div class="card-body">
                <div class="relative h-64" wire:ignore>
                    <canvas id="chart-students-grade-level" role="img"
                        aria-label="Bar chart of distinct students per grade level"></canvas>
                </div>
            </div>
        </x-flowbite.card>

        <x-flowbite.card>
            <x-slot name="header">
                <div class="min-w-0 p-4">
                    <h2 class="text-base font-semibold text-heading">Students by sex</h2>
                    <p class="mt-1 text-sm text-body-subtle">
                        Distribution of enrolled students.
                    </p>
                </div>
            </x-slot>
            <div class="card-body">
                <div class="relative h-64" wire:ignore>
                    <canvas id="chart-students-sex" role="img"
                        aria-label="Doughnut chart of students by sex"></canvas>
                </div>
            </div>
        </x-flowbite.card>
    </div>

    <div>
        <span class="side-label">Modules</span>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('students.index') }}"
                class="group card transition-colors hover:bg-neutral-secondary-soft focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bento-ink">
                <div class="card-body flex flex-col items-start gap-2">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-base bg-neutral-secondary text-body">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold text-heading">Students</span>
                    <span class="text-sm text-body-subtle">Enrollment records, sections and student files.</span>
                    <span class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-fg-brand">
                        Manage students
                        <svg aria-hidden="true" class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('strands.index') }}"
                class="group card transition-colors hover:bg-neutral-secondary-soft focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bento-ink">
                <div class="card-body flex flex-col items-start gap-2">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-base bg-neutral-secondary text-body">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold text-heading">Strands</span>
                    <span class="text-sm text-body-subtle">Academic tracks students are assigned to.</span>
                    <span class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-fg-brand">
                        Manage strands
                        <svg aria-hidden="true" class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('grade_levels.index') }}"
                class="group card transition-colors hover:bg-neutral-secondary-soft focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bento-ink">
                <div class="card-body flex flex-col items-start gap-2">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-base bg-neutral-secondary text-body">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold text-heading">Grade Levels</span>
                    <span class="text-sm text-body-subtle">The grade levels students are placed in.</span>
                    <span class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-fg-brand">
                        Manage grade levels
                        <svg aria-hidden="true" class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('school_years.index') }}"
                class="group card transition-colors hover:bg-neutral-secondary-soft focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bento-ink">
                <div class="card-body flex flex-col items-start gap-2">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-base bg-neutral-secondary text-body">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </span>
                    <span class="text-base font-semibold text-heading">School Years</span>
                    <span class="text-sm text-body-subtle">Academic years that frame enrollment and records.</span>
                    <span class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-fg-brand">
                        Manage school years
                        <svg aria-hidden="true" class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </a>
        </div>
    </div>

    {{-- <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-flowbite.card class="lg:col-span-2">
            <x-slot name="header">
                <div class="min-w-0">
                    <h2 class="text-base font-semibold text-heading">Configuration</h2>
                    <p class="mt-1 text-sm text-body-subtle">
                        Keep the reference data consistent across the application.
                    </p>
                </div>
            </x-slot>
            <div class="card-body flex flex-wrap gap-3">
                <x-flowbite.button variant="secondary" :href="route('strands.create')">
                    New strand
                </x-flowbite.button>
                <x-flowbite.button variant="secondary" :href="route('school_years.create')">
                    New school year
                </x-flowbite.button>
                <x-flowbite.button variant="secondary" :href="route('grade_levels.create')">
                    New grade level
                </x-flowbite.button>
            </div>
        </x-flowbite.card>

        <x-flowbite.card>
            <x-slot name="header">
                <h2 class="text-base font-semibold text-heading">Core transaction</h2>
            </x-slot>
            <div class="card-body">
                <p class="text-sm text-body-subtle">
                    Add a student record to start an enrollment.
                </p>
                <x-flowbite.button :href="route('students.create')" class="mt-4">
                    New student
                </x-flowbite.button>
            </div>
        </x-flowbite.card>
    </div> --}}
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            if (typeof Chart === 'undefined') {
                return;
            }

            const styles = getComputedStyle(document.documentElement);
            const token = (name) => styles.getPropertyValue(name).trim();

            Chart.defaults.font.family = token('--font-sans');
            Chart.defaults.font.size = 12;
            Chart.defaults.color = token('--color-body-subtle');

            const bar = (id, labels, values) => {
                const el = document.getElementById(id);
                if (!el) return;

                new Chart(el, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: token('--color-bento-primary'),
                            hoverBackgroundColor: token('--color-bento-primary-hover'),
                            borderRadius: 6,
                            maxBarThickness: 48,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                displayColors: false
                            },
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    color: token('--color-body-subtle')
                                },
                            },
                            y: {
                                beginAtZero: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: token('--color-default-subtle')
                                },
                                ticks: {
                                    color: token('--color-body-subtle'),
                                    precision: 0,
                                    padding: 8,
                                },
                            },
                        },
                    },
                });
            };

            const donut = (id, labels, values, palette) => {
                const el = document.getElementById(id);
                if (!el) return;

                new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: values.map((_, i) => token(palette[i % palette
                                .length])),
                            borderColor: token('--color-neutral-primary-soft'),
                            borderWidth: 2,
                            hoverOffset: 4,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    padding: 16,
                                    color: token('--color-body'),
                                },
                            },
                        },
                    },
                });
            };

            bar('chart-students-school-year', @json($school_year->pluck('name')), @json($school_year->pluck('students')));
            bar('chart-students-grade-level', @json($grade_level->pluck('name')), @json($grade_level->pluck('students')));
            donut('chart-students-strand', @json($strand->pluck('name')), @json($strand->pluck('students')),
                ['--color-bento-primary', '--color-gray-600', '--color-gray-400', '--color-gray-200']);
            donut('chart-students-sex', @json($sex->pluck('name')), @json($sex->pluck('students')),
                ['--color-bento-primary', '--color-gray-400']);
        })();
    </script>
@endpush
