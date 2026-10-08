<?php

namespace App\Repositories;

use App\Models\FileType;

class FileTypeRepository
{
    public function index()
    {
        return FileType::all();
    }

    public function store(array $data)
    {
        return FileType::create($data);
    }

    public function show(int $id)
    {
        return FileType::findOrFail($id);
    }

    public function update(FileType $model, array $data)
    {
        return $model->update($data);
    }

    public function destroy(FileType $model)
    {
        return $model->delete();
    }
}
