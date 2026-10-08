<?php

use Livewire\Component;
use App\Models\Student;

new class extends Component {
    //
    public Student $student;

    public function mount($student)
    {
        $this->student = $student;
    }
};
?>

<div>
    <x-flowbite.card>
        <x-flowbite.card-header title="Student Files" subtitle="School year, grade level, strand and section assignments.">
            <x-slot:actions>
                <x-flowbite.button :href="route('student.create_file', ['student_id' => $this->student])">
                    Upload file
                </x-flowbite.button>
            </x-slot:actions>
        </x-flowbite.card-header>

        <div>
            @if ($this->student->files->isEmpty())
                <x-flowbite.table>
                    <x-slot:header>
                        <x-flowbite.table-header>Type</x-flowbite.table-header>
                        <x-flowbite.table-header>File</x-flowbite.table-header>
                        <x-flowbite.table-header>Action</x-flowbite.table-header>
                    </x-slot:header>
                </x-flowbite.table>

                <x-flowbite.card-body>
                    <x-flowbite.empty-state title="No uploaded files"
                        description="This student has not uploaded any files yet. Uploaded documents will appear here."
                        class="p-0">
                    </x-flowbite.empty-state>
                </x-flowbite.card-body>
            @else
                <x-flowbite.table>
                    <x-slot:header>
                        <x-flowbite.table-header>Type</x-flowbite.table-header>
                        <x-flowbite.table-header>File</x-flowbite.table-header>
                        <x-flowbite.table-header>Action</x-flowbite.table-header>
                    </x-slot:header>

                    <x-slot:body>
                        @foreach ($this->student->files as $file)
                            <tr>
                                <x-flowbite.table-row>
                                    {{ ucwords($file->file_type->name) }}
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    <a href="{{ Storage::url($file->path) }}" target="_blank">
                                        {{ $this->student->student_id }}_{{ $file->file_type->name }}
                                    </a>
                                </x-flowbite.table-row>

                                <x-flowbite.table-row>
                                    @php
                                        $modal_id = 'modal-delete-' . $file->id;
                                    @endphp

                                    <button data-modal-target="{{ $modal_id }}"
                                        data-modal-toggle="{{ $modal_id }}" class="btn">Delete</button>

                                    <x-flowbite.modal id="{{ $modal_id }}" title="Confirmation">
                                        <p>Are you sure you want to delete this document?</p>

                                        <x-slot:footerSlot>
                                            <div class="flex gap-2 justoy">
                                                <x-flowbite.button variant="ghost" type="button">
                                                    No
                                                </x-flowbite.button>

                                                <form method="POST"
                                                    action="{{ route('student.destroy_file', $file->id) }}">
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
    </x-flowbite.card>
</div>
