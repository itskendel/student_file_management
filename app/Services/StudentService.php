<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Http\Request;

class StudentService
{
    public function __construct(protected StudentRepository $repo_student) {}

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
        ]);

        $student = $this->repo_student->show($id);

        return $this->repo_student->update($student, $data);
    }

    public function destroy(int $id)
    {
        $student = $this->repo_student->show($id);

        return $this->repo_student->destroy($student);
    }
}
