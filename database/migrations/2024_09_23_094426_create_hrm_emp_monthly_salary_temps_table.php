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
        Schema::create('hrm_emp_monthly_salary_temp', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->year('year');
            $table->integer('month');
            $table->double('basic');
            $table->double('h_rent');
            $table->double('med');
            $table->double('conv');
            $table->double('food');
            $table->double('tot_add');
            $table->double('tot_deduct');
            $table->double('salary_advanced');
            $table->double('leave_deduct');
            $table->integer('late_days');
            $table->integer('leave_days');
            $table->integer('abcent_days');
            $table->double('overtime_inhour');
            $table->dateTime('generate_date');
            $table->integer('generate_by');
            $table->dateTime('update_date');
            $table->integer('update_by');
            $table->integer('approve_by');
            $table->dateTime('process_date');
            $table->integer('process_by');
            $table->integer('process_stat');
            $table->double('pf_office');
            $table->double('pf_employee');
            $table->double('revenue_stamp');
            $table->double('welfare_fund');
            $table->integer('payment_mode');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_emp_monthly_salary_temp');
    }
};
