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
        Schema::create('spp_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trn')->unique();
            $table->date('date');
            $table->double('amount');
            $table->foreignId('student_id')->constrained();
            $table->foreignId('coa_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('due_id')->constrained();
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_transactions');
    }
};
