<?php

namespace App\Models;

class TeachingJournal extends Model
{
    protected $table = 'teaching_journals';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function learning_activity()
    {
        return $this->belongsTo(LearningActivity::class);
    }
}
