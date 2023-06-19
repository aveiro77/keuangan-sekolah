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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trn')->unique();
            $table->date('date');
            $table->string('description')->require();
            $table->foreignId('partner_id')->constrained();
            $table->foreignId('coa_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->double('sub_total')->require();
            $table->string('tax')->require();
            $table->double('ppn')->require();
            $table->double('grand_total')->require();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
