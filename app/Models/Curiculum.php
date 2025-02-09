<?php

namespace App\Models;

class Curiculum extends Model
{
    protected $table = 'curiculums';

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
