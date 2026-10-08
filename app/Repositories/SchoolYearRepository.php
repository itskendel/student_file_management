<?php

namespace App\Repositories;

use App\Models\SchoolYear;

class SchoolYearRepository
{
    public function index()
    {
        return SchoolYear::all();
    }

    public function store(array $data)
    {
        return SchoolYear::create($data);
    }

    public function show(int $id)
    {
        return SchoolYear::with(['academic_records.student', 'academic_records.grade_level', 'academic_records.strand'])
            ->findOrFail($id);
    }

    public function update(SchoolYear $model, array $data)
    {
        $model->update($data);

        return $model;
    }

    public function destroy(SchoolYear $model)
    {
        return $model->delete();
    }
}
