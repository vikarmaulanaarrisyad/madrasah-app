<?php

namespace App\Models;

class LearningActivity extends Model
{
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'm_level_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'learning_activity_student', 'learning_activity_id', 'student_id')->withTimestamps();
    }
}
