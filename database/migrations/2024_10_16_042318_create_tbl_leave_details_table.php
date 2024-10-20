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
        Schema::create('tbl_leave_details', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_id');
            $table->dateTime('dates');
            $table->integer('leavetype_id');
            $table->integer('emp_id');
            $table->integer('day_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_leave_details');
    }
};
