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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->string('trn')->require();
            $table->date('date');
            $table->string('description')->require();
            $table->foreignId('coa_id')->constrained();
            $table->integer('coa_id2')->require();
            $table->string('coa2')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->double('debit')->require();
            $table->double('credit')->require();
            $table->integer('stack')->require();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
