<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strand extends AuditableModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'desc'];

    public function academic_records()
    {
        return $this->hasMany(AcademicRecord::class);
    }
}
