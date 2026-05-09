<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            // Already exists
            // $table->foreignId('hackathon_id')
            //       ->nullable()
            //       ->constrained('hackathons')
            //       ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            // Already exists
            // $table->dropForeign(['hackathon_id']);
            // $table->dropColumn('hackathon_id');

        });
    }
};