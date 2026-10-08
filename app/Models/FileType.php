<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileType extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['name', 'desc'];

    public function student_files()
    {
        return $this->hasMany(StudentFile::class);
    }
}
