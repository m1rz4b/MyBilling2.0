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
        Schema::create('tbl_leave', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('days');
            $table->integer('leavetype_id');
            $table->text('remarks');
            $table->integer('status');
            $table->integer('approved_by');
            $table->dateTime('approved_time');
            $table->integer('day_type');
            $table->text('approve_remarks');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_leave');
    }
};