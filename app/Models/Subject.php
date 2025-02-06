<?php

namespace App\Models;

class Subject extends Model
{
    public function curiculum()
    {
        return $this->belongsTo(Curiculum::class);
    }
}
