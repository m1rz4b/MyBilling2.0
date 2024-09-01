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
        Schema::create('mas_employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_no', 50);
            $table->string('emp_name', 120);
            $table->date('date_of_birth');
            $table->date('date_of_joing');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('mas_departments');
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('mas_designation');
            $table->text('address');
            $table->string('mobile', 30);
            $table->string('email', 40);
            $table->integer('suboffice_id');
            $table->unsignedBigInteger('emp_status_id');
            $table->foreign('emp_status_id')->references('id')->on('employee_status');
            $table->integer('payment_mode');
            $table->integer('bank_id');
            $table->string('acc_no', 150);
            $table->integer('shift_id');
            $table->integer('salary_status');   //previously salry_status
            $table->date('last_increment_date');
            $table->double('last_increment_amount');
            $table->integer('blood_group');
            $table->string('mobile1', 50);  //Previously mobile1
            $table->string('work_station', 100);
            $table->string('father_name');
            $table->date('date_of_resig');
            $table->string('birth_certificate', 100);
            $table->string('gender', 50);
            $table->integer('system_user_id');
            $table->date('last_promotion_date');
            $table->string('image', 100);
            $table->string('provision_days', 10);
            $table->string('e-tin', 100);
            $table->integer('user_group_id');
            $table->integer('reporting_manager');
            $table->integer('reporting_manager_des');
            $table->integer('emp_type_name');
            $table->date('date_of_permanent');
            $table->integer('roster_shift');
            $table->string('emp_pin');
            $table->integer('status');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_employees');
    }
};
