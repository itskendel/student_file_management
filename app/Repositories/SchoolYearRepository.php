<?php

namespace App\Repositories;

use App\Models\SchoolYear;

class SchoolYearRepository
{
    public function index()
    {
        return SchoolYear::all();
    }

    public function store() {}

    public function show() {}

    public function update() {}

    public function destroy() {}
}
