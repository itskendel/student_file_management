<?php

namespace App\Services;

use App\Repositories\StudentFileRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentService
{
    public function __construct(
        protected StudentRepository $repo_student,
        protected StudentFileRepository $repo_docu,
    ) {}

    public function analytics(): array
    {
        return $this->repo_student->analytics();
    }

    public function index(int $page = 10, ?string $search = null, array $filters = [])
    {
        return $this->repo_student->index($page, $search, $filters);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'nullable|string|unique:students,student_id',
            'lrn' => 'nullable|string|unique:students,lrn',

            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',

            'birth_date' => 'required|date|before:today',
            'sex' => 'required|string',

            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',

            'school_year_id' => 'required|integer|exists:school_years,id',
            'strand_id' => 'required|integer|exists:strands,id',
            'grade_level_id' => 'required|integer|exists:grade_levels,id',
            'section' => 'required|string|max:255',
        ]);

        return $this->repo_student->store($data);
    }

    public function show(int $id)
    {
        return $this->repo_student->show($id);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'student_id' => ['nullable', 'string', Rule::unique('students', 'student_id')->ignore($id)],
            'lrn' => ['nullable', 'string', Rule::unique('students', 'lrn')->ignore($id)],

            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',

            'birth_date' => 'required|date|before:today',
            'sex' => 'required|string',

            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $student = $this->repo_student->show($id);

        return $this->repo_student->update($student, $data);
    }

    public function destroy(int $id)
    {
        $student = $this->repo_student->show($id);

        return $this->repo_student->destroy($student);
    }

    public function index_file(int $student_id)
    {
        return $this->repo_docu->index($student_id);
    }

    public function store_file(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'file_type_id' => 'required|exists:file_types,id',
            'document' => ['required', 'file', 'mimes:pdf'],
        ]);

        $student_number = $this->repo_student->show($request->student_id)->student_id;
        $path = $request->file('document')->store('student_documents/'.$student_number, 'public');

        $data = [
            'student_id' => $request->student_id,
            'file_type_id' => $request->file_type_id,
            'path' => $path,
        ];

        return $this->repo_docu->store($data);
    }

    public function destroy_file(int $file_id)
    {
        $model = $this->repo_docu->show($file_id);

        return $this->repo_docu->destroy($model);
    }
}
