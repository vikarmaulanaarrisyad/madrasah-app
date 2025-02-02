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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('curiculum_id');
            $table->unsignedBigInteger('subject_id');
            $table->bigInteger('daily_score')->default(0);
            $table->bigInteger('midterm_score')->default(0);
            $table->bigInteger('final_score')->default(0);
            $table->bigInteger('final_grade')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
