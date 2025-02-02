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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('full_name');
            $table->string('brith_place');
            $table->date('birth_date');
            $table->unsignedBigInteger('m_gender_id');
            $table->unsignedBigInteger('m_religion_id');
            $table->text('address')->nullable();
            $table->text('full_address')->nullable();
            $table->string('rt');
            $table->string('rw');
            $table->integer('postal_code_num')->default(0);
            $table->date('tmt_teacher');
            $table->date('tmt_employe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
