<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['student_id', 'lrn', 'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'sex', 'email', 'phone_number', 'address'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function academic_records()
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function files()
    {
        return $this->hasMany(StudentFile::class)
            ->orderBy('file_type_id');
    }
}
