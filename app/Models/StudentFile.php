<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFile extends AuditableModel
{
    /** @use HasFactory<\Database\Factories\StudentFileFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['student_id', 'file_type_id', 'path'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function file_type()
    {
        return $this->belongsTo(FileType::class, 'file_type_id');
    }
}
