<?php

namespace App\Models;

class Student extends Model
{
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'm_gender_id', 'id');
    }
}
