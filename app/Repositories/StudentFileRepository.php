<?php

namespace App\Repositories;

use App\Models\StudentFile;

class StudentFileRepository
{
    public function index(int $student_id)
    {
        return StudentFile::where('student_id', $student_id)
            ->orderByDesc('file_type_id')
            ->get();
    }

    public function store(array $data)
    {
        return StudentFile::create($data);
    }

    public function show(int $id)
    {
        return StudentFile::findOrFail($id);
    }

    public function destroy(StudentFile $model)
    {
        return $model->delete();
    }
}
