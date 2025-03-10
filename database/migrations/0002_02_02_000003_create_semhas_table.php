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
        Schema::create('semhas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sempro_id')->constrained('sempro')->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained('periodes')->cascadeOnDelete();
            $table->string('kompre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semhas');
    }
};
