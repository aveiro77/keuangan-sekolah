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
            $table->string('nisn')->require();
            $table->string('fullname')->require();
            $table->string('group')->require();
            $table->foreignId('active_year_id')->constrained();
            $table->string('temp_status')->nullable();
            $table->timestamps();

            $table->unique(['nisn', 'active_year_id']);
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
