<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('break_times', function (Blueprint $table) {
            $table->time('apply_break_start')->nullable()->after('break_start');
            $table->time('apply_break_end')->nullable()->after('break_end');
        });
    }

    public function down(): void
    {
        Schema::table('break_times', function (Blueprint $table) {
            $table->dropColumn([
                'apply_break_start',
                'apply_break_end',
            ]);
        });
    }
};
