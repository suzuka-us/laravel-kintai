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
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('apply_clock_in')->nullable()->after('clock_in');
            $table->time('apply_clock_out')->nullable()->after('clock_out');
            $table->text('apply_remark')->nullable()->after('remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'apply_clock_in',
                'apply_clock_out',
                'apply_remark',
            ]);
        });
    }
};
