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
            $table->id(); //previously emp_id
            $table->string('emp_no', 50)->nullable();
            $table->string('emp_name', 120);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_joining');
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
            $table->double('last_increment_amount')->nullable();
            $table->integer('blood_group')->nullable();
            $table->string('mobile1', 50)->nullable();
            $table->string('work_station', 100)->nullable();
            $table->string('father_name')->nullable();
            $table->date('date_of_resig')->nullable();
            $table->string('birth_certificate', 100)->nullable();
            $table->string('gender', 50)->nullable();
            $table->integer('system_user_id')->nullable();
            $table->date('last_promotion_date');
            $table->string('image', 100)->nullable();
            $table->string('provision_days', 10)->nullable();
            $table->string('e_tin', 100);   //previously e-tin
            $table->integer('user_group_id');
            $table->integer('reporting_manager');
            $table->integer('reporting_manager_des');
            $table->integer('emp_type_name')->nullable();
            $table->date('date_of_permanent')->nullable();
            $table->integer('roster_shift')->nullable();
            $table->string('emp_pin');
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
