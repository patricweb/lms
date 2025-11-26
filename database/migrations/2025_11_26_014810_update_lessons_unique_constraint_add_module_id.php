<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropUnique(['course_id', 'order']);

            $table->unique(['course_id', 'module_id', 'order'], 'lessons_course_module_order_unique');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropUnique(['course_id', 'module_id', 'order']);
            $table->unique(['course_id', 'order'], 'lessons_course_order_unique');
        });
    }
};