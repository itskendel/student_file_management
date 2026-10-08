<?php

namespace App\Repositories;

use App\Models\GradeLevel;

class GradeLevelRepository
{
    public function index()
    {
        return GradeLevel::all();
    }

    public function store(array $data)
    {
        return GradeLevel::create($data);
    }

    public function show(int $id)
    {
        return GradeLevel::with(['academic_records.student', 'academic_records.school_year', 'academic_records.strand'])
            ->findOrFail($id);
    }

    public function update(GradeLevel $model, array $data)
    {
        $model->update($data);

        return $model;
    }

    public function destroy(GradeLevel $model)
    {
        return $model->delete();
    }
}
