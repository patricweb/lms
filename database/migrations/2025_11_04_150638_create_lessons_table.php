<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->longText('content');
            $table->string('video_url')->nullable();
            $table->integer('order');
            $table->integer('duration');
            $table->boolean('is_free_preview')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('course_id');
            $table->unique(['course_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
