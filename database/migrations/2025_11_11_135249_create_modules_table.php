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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // К курсу
            $table->string('title'); // "Модуль 1: Основы"
            $table->text('description')->nullable(); // Краткое описание
            $table->integer('order')->default(1); // Порядок модулей в курсе
            $table->timestamps();

            $table->index('course_id');
            $table->unique(['course_id', 'order']); // Уникальный порядок
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
