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
        Schema::table('teaching_journals', function (Blueprint $table) {
            $table->unsignedBigInteger('learning_activity_id');
            $table->longText('cp');
            $table->longText('material');
            $table->text('task');
            $table->integer('Izin')->default(0);
            $table->integer('Sakit')->default(0);
            $table->integer('Alpa')->default(0);
            $table->integer('Hadir')->default(0);
            $table->text('description')->default('-');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_journals', function (Blueprint $table) {
            $table->dropColumn([
                'learning_activity_id',
                'cp',
                'material',
                'task',
                'Izin',
                'Sakit',
                'Alpa',
                'Hadir',
                'description'

            ]);
        });
    }
};
