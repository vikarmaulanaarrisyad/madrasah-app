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
        Schema::create('grading_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('curiculum_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('daily_score_weight')->default(0);
            $table->integer('midterm_score_weight')->default(0);
            $table->integer('final_score_weight')->default(0);
            $table->integer('kkm')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_settings');
    }
};
