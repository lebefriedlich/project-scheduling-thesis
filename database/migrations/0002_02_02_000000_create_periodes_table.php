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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['sempro', 'semhas', 'skripsi']);
            $table->date('start_schedule');
            $table->date('end_schedule');
            $table->bigInteger('quota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
