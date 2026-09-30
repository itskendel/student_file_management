<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['student_id', 'lrn', 'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'sex', 'email', 'phone_number', 'address'];

    public function academic_records()
    {
        return $this->hasMany(AcademicRecord::class);
    }
}
