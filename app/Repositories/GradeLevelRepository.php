<?php

namespace App\Repositories;

use App\Models\GradeLevel;

class GradeLevelRepository
{
    public function index()
    {
        return GradeLevel::all();
    }

    public function store() {}

    public function show() {}

    public function update() {}

    public function destroy() {}
}
