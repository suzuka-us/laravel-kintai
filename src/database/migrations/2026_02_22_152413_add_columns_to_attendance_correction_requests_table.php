<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('attendance_correction_requests', function (Blueprint $table) {
            $table->time('apply_clock_in')->nullable();
            $table->time('apply_clock_out')->nullable();
            $table->text('remark')->nullable();
        });
    }

    public function down()
    {
        Schema::table('attendance_correction_requests', function (Blueprint $table) {
            $table->dropColumn(['apply_clock_in', 'apply_clock_out', 'remark']);
        });
    }
};
