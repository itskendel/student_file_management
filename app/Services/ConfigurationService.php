<?php

namespace App\Services;

use App\Repositories\GradeLevelRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\StrandRepository;

class ConfigurationService
{
    public function __construct(
        protected GradeLevelRepository $repo_grade_level,
        protected SchoolYearRepository $repo_school_year,
        protected StrandRepository $repo_strand,
    ) {}

    public function index_grade_level()
    {
        return $this->repo_grade_level->index();
    }

    public function index_school_year()
    {
        return $this->repo_school_year->index();
    }

    public function index_strand()
    {
        return $this->repo_strand->index();
    }
}
