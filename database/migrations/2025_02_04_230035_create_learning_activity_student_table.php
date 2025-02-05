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
        Schema::create('learning_activity_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_activity_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('learning_activity_id')->references('id')->on('learning_activities')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_activity_student');
    }
};
