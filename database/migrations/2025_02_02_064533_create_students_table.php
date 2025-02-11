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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('nik')->nullable();
            $table->string('nisn')->nullable();
            $table->string('local_nis')->nullable();
            $table->unsignedBigInteger('m_gender_id');
            $table->unsignedBigInteger('m_religion_id');
            $table->unsignedBigInteger('m_life_goal_id');
            $table->unsignedBigInteger('m_hobby_id');
            $table->unsignedBigInteger('m_residence_status_id');
            $table->unsignedBigInteger('m_residence_distance_id');
            $table->unsignedBigInteger('m_interval_time_id');
            $table->unsignedBigInteger('m_transportation_id');
            $table->text('address')->nullable();
            $table->text('full_address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->integer('postal_code_num')->default(0);
            $table->integer('height')->default(0);
            $table->integer('weight')->default(0);
            $table->integer('child_of_num')->default(0);
            $table->integer('siblings_num')->default(0);
            $table->integer('entered_tk_ra')->default(0);
            $table->integer('entered_paud')->default(0);
            $table->string('handphone')->nullable();
            $table->string('kk_num')->nullable();
            $table->string('upload_photo')->default('photo.jpg');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
