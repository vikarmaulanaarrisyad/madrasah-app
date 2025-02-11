<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('father_full_name');
            $table->unsignedBigInteger('father_m_life_status_id');
            $table->string('father_nik');
            $table->string('father_birth_place');
            $table->date('father_birth_date');
            $table->unsignedBigInteger('father_m_last_education_id');
            $table->unsignedBigInteger('father_m_job_id');
            $table->unsignedBigInteger('father_m_average_income_per_month_id');
            $table->string('father_phone_number')->nullable();
            $table->text('father_address')->nullable();
            $table->string('father_rt')->nullable();
            $table->string('father_rw')->nullable();
            $table->integer('father_postal_code');
            $table->string('father_kk_file')->default('father_kk.jpg');
            $table->string('mother_full_name');
            $table->unsignedBigInteger('mother_m_life_status_id');
            $table->string('mother_nik');
            $table->string('mother_birth_place');
            $table->date('mother_birth_date');
            $table->unsignedBigInteger('mother_m_last_education_id');
            $table->unsignedBigInteger('mother_m_job_id');
            $table->unsignedBigInteger('mother_m_average_income_per_month_id');
            $table->string('mother_phone_number')->nullable();
            $table->text('mother_address')->nullable();
            $table->string('mother_rt')->nullable();
            $table->string('mother_rw')->nullable();
            $table->integer('mother_postal_code');
            $table->string('mother_kk_file')->default('mother_kk.jpg');
            $table->string('wali_full_name')->nullable();
            $table->unsignedBigInteger('wali_m_life_status_id')->nullable();
            $table->string('wali_nik')->nullable();
            $table->string('wali_birth_place')->nullable();
            $table->date('wali_birth_date')->nullable();
            $table->unsignedBigInteger('wali_m_last_education_id')->nullable();
            $table->unsignedBigInteger('wali_m_job_id')->nullable();
            $table->unsignedBigInteger('wali_m_average_income_per_month_id')->nullable();
            $table->string('wali_phone_number')->nullable();
            $table->text('wali_address')->nullable();
            $table->string('wali_rt')->nullable();
            $table->string('wali_rw')->nullable();
            $table->integer('wali_postal_code');
            $table->string('wali_kk_file')->default('wali_kk.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
