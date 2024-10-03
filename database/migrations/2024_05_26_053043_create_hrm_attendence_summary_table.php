<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hrm_attendance_summary', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');  //Renamed from 'emp_id'
            $table->integer('shift_id')->nullable();
            $table->date('date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('total_time');
            $table->double('over_time');  //Renamed from 'ot_time'
            $table->integer('late_mark')->default(0);
            $table->integer('early_mark')->default(0);
            $table->integer('leave_mark')->default(0);
            $table->integer('leave_type')->default(0);
            $table->integer('gov_holiday')->default(0);
            $table->integer('weekly_holiday')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('administrative')->nullable();
            $table->integer('entry_by');
            $table->dateTime('entry_date');
            $table->integer('update_by');
            $table->dateTime('update_date');
            $table->integer('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->unique(['employee_id', 'deleted_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_attendance_summary');
    }
};
