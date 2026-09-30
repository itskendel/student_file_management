<?php

namespace App\Repositories;

use App\Models\Strand;

class StrandRepository
{
    public function index()
    {
        return Strand::all();
    }

    public function store() {}

    public function show() {}

    public function update() {}

    public function destroy() {}
}
