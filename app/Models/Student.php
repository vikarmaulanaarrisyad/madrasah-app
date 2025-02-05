<?php

namespace App\Models;

class Student extends Model
{
    // Relationship with Gender
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'm_gender_id', 'id');
    }

    // Relationship with Religion
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'm_religion_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'student_id', 'id');
    }

    // Relationship with Hobby
    public function hobby()
    {
        return $this->belongsTo(Hobby::class, 'm_hobby_id', 'id');
    }

    // Relationship with LifeGoal
    public function lifeGoal()
    {
        return $this->belongsTo(LifeGoal::class, 'm_life_goal_id', 'id');
    }

    // Relationship with ResidenceDistance
    public function residenceDistance()
    {
        return $this->belongsTo(ResidenceDistance::class, 'm_residence_distance_id', 'id');
    }

    // Relationship with ResidenceStatus
    public function residenceStatus()
    {
        return $this->belongsTo(ResidenceStatus::class, 'm_residence_status_id', 'id');
    }

    // Relationship with Time
    public function time()
    {
        return $this->belongsTo(Time::class, 'm_time_id', 'id');
    }

    // Relationship with Transportation
    public function transportation()
    {
        return $this->belongsTo(Transportation::class, 'm_transportation_id', 'id');
    }

    public function learningActivities()
    {
        return $this->belongsToMany(LearningActivity::class, 'learning_activity_student', 'student_id', 'learning_activity_id');
    }
}
