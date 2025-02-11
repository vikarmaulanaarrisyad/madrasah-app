<?php

namespace App\Models;

class Attendances extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
