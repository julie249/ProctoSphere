<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dateTime('exam_start_time')->nullable()->after('is_active');
            $table->dateTime('exam_end_time')->nullable()->after('exam_start_time');
        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['exam_start_time', 'exam_end_time']);
        });
    }
};