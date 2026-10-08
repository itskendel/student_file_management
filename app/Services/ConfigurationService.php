<?php

namespace App\Services;

use App\Repositories\FileTypeRepository;
use App\Repositories\GradeLevelRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\StrandRepository;
use Illuminate\Http\Request;

class ConfigurationService
{
    public function __construct(
        protected GradeLevelRepository $repo_grade_level,
        protected SchoolYearRepository $repo_school_year,
        protected StrandRepository $repo_strand,
        protected FileTypeRepository $repo_file_type,
    ) {}

    public function index_grade_level()
    {
        return $this->repo_grade_level->index();
    }

    public function store_grade_level(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
        ]);

        return $this->repo_grade_level->store($data);
    }

    public function show_grade_level(int $id)
    {
        return $this->repo_grade_level->show($id);
    }

    public function update_grade_level(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
        ]);

        $model = $this->repo_grade_level->show($id);

        return $this->repo_grade_level->update($model, $data);
    }

    public function destroy_grade_level(int $id) {
        $model = $this->repo_grade_level->show($id);

        return $this->repo_grade_level->destroy($model);
    }

    public function index_school_year()
    {
        return $this->repo_school_year->index();
    }

    public function store_school_year(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
        ]);

        return $this->repo_school_year->store($data);
    }

    public function show_school_year(int $id)
    {
        return $this->repo_school_year->show($id);
    }

    public function update_school_year(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
        ]);

        $model = $this->repo_school_year->show($id);

        return $this->repo_school_year->update($model, $data);
    }

    public function destroy_school_year(int $id)
    {
        $model = $this->repo_school_year->show($id);

        return $this->repo_school_year->destroy($model);
    }

    public function index_strand()
    {
        return $this->repo_strand->index();
    }

    public function store_strand(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        return $this->repo_strand->store($data);
    }

    public function show_strand(int $id)
    {
        return $this->repo_strand->show($id);
    }

    public function update_strand(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        $model = $this->repo_strand->show($id);

        return $this->repo_strand->update($model, $data);
    }

    public function destroy_strand(int $id)
    {
        $model = $this->repo_strand->show($id);

        return $this->repo_strand->destroy($model);
    }

    public function index_file_type()
    {
        return $this->repo_file_type->index();
    }
}
