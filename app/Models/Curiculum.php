<?php

namespace App\Models;

class Curiculum extends Model
{
    protected $table = 'curiculums';

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
