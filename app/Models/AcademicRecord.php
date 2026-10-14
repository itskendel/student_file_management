<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Models\Audit;

class AcademicRecord extends AuditableModel
{
    /** @use HasFactory<\Database\Factories\AcademicRecordFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['student_id', 'school_year_id', 'grade_level_id', 'strand_id', 'section'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id')
            ->withTrashed();
    }

    public function grade_level()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id')
            ->withTrashed();
    }

    public function strand()
    {
        return $this->belongsTo(Strand::class, 'strand_id')
            ->withTrashed();
    }
}
