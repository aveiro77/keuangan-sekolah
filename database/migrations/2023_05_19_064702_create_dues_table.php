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
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->double('total_amount')->require();
            $table->string('type')->require();
            $table->string('group')->require();
            $table->foreignId('active_year_id')->constrained();
            $table->timestamps();

            $table->unique(['name', 'active_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dues');
    }
};
