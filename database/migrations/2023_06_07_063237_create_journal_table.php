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
        Schema::create('journal', function (Blueprint $table) {
            $table->id();
            $table->string('trn')->required();
            $table->date('date')->required();
            $table->double('debit')->required();
            $table->double('credit')->required();
            $table->integer('coa_id')->required();
            $table->integer('coa_id2')->nullable();
            $table->integer('partner_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('due_id')->nullable();
            $table->integer('stack')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal');
    }
};
