<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    public function index(int $page = 10, ?string $search = null, array $filters = [])
    {
        $query = Student::query();

        $query->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('middle_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('student_id', 'LIKE', "%{$search}%")
                    ->orWhere('lrn', 'LIKE', "%{$search}%")
                    ->orWhereHas('academic_records', function ($qp) use ($search) {
                        $qp->where('section', 'LIKE', "%{$search}%");
                    });
            });
        });

        $strand_id = $filters['strand_id'] ?? null;
        $grade_level_id = $filters['grade_level_id'] ?? null;
        $school_year_id = $filters['school_year_id'] ?? null;

        $query->when(
            $strand_id || $grade_level_id || $school_year_id,
            function ($q) use ($strand_id, $grade_level_id, $school_year_id) {
                $q->whereHas('academic_records', function ($qq) use ($strand_id, $grade_level_id, $school_year_id) {
                    $qq->when($strand_id, function ($q) use ($strand_id) {
                        $q->where('strand_id', $strand_id);
                    });

                    $qq->when($grade_level_id, function ($q) use ($grade_level_id) {
                        $q->where('grade_level_id', $grade_level_id);
                    });

                    $qq->when($school_year_id, function ($q) use ($school_year_id) {
                        $q->where('school_year_id', $school_year_id);
                    });
                });
            }
        );

        return $query
            ->with([
                'academic_records' => fn ($q) => $q->latest('id'),
                'academic_records.school_year',
                'academic_records.grade_level',
                'academic_records.strand',
            ])
            ->orderBy('first_name')
            ->paginate($page);
    }

    public function store(array $data)
    {
        $student = Student::create([
            'student_id' => $data['student_id'] ?? null,
            'lrn' => $data['lrn'] ?? null,
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'] ?? null,
            'birth_date' => $data['birth_date'],
            'sex' => $data['sex'],
            'email' => $data['email'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        $student->academic_records()->create([
            'school_year_id' => $data['school_year_id'],
            'grade_level_id' => $data['grade_level_id'],
            'strand_id' => $data['strand_id'],
            'section' => $data['section'],
        ]);

        return $student;
    }

    public function show(int $id)
    {
        return Student::with(['academic_records.school_year', 'academic_records.grade_level', 'academic_records.strand'])
            ->findOrFail($id);
    }

    public function update(Student $student, array $data)
    {
        $student->update($data);

        return $student;
    }

    public function destroy(Student $student)
    {
        return $student->delete();
    }
}
