<?php

namespace App\Repositories;

use App\Models\Strand;

class StrandRepository
{
    public function index()
    {
        return Strand::all();
    }

    public function store(array $data)
    {
        return Strand::create($data);
    }

    public function show(int $id)
    {
        return Strand::with(['academic_records.student', 'academic_records.school_year', 'academic_records.grade_level'])
            ->findOrFail($id);
    }

    public function update(Strand $model, $data)
    {
        return $model->update($data);
    }

    public function destroy(Strand $model)
    {
        return $model->delete();
    }
}
