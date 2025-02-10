<?php

namespace App\Models;

class Parents extends Model
{
    // protected $table = 'parents';

    // Relationship with Job
    public function job_father()
    {
        return $this->belongsTo(Job::class, 'father_m_job_id', 'id');
    }

    // Relationship with Education
    public function education_father()
    {
        return $this->belongsTo(Education::class, 'father_m_last_education_id', 'id');
    }

    public function average_income_father()
    {
        return $this->belongsTo(AverageIncome::class, 'father_m_average_income_per_month_id', 'id');
    }

    public function life_status_father()
    {
        return $this->belongsTo(LifeStatus::class, 'father_m_life_status_id', 'id');
    }

    public function job_mother()
    {
        return $this->belongsTo(Job::class, 'mother_m_job_id', 'id');
    }

    // Relationship with Education
    public function education_mother()
    {
        return $this->belongsTo(Education::class, 'mother_m_last_education_id', 'id');
    }

    public function average_income_mother()
    {
        return $this->belongsTo(AverageIncome::class, 'mother_m_average_income_per_month_id', 'id');
    }

    public function life_status_mother()
    {
        return $this->belongsTo(LifeStatus::class, 'mother_m_life_status_id', 'id');
    }
}
