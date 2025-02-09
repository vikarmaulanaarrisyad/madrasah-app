<?php

namespace App\Models;

class Teacher extends Model
{
    protected $table = 'teachers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learningActivities()
    {
        return $this->hasMany(LearningActivity::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'm_gender_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'm_religion_id');
    }
}
