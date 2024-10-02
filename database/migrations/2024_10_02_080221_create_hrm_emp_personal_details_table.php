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
        Schema::create('hrm_emp_personal_details', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id')->unique('emp_id');
            $table->integer('gender');
            $table->integer('marital_status');
            $table->integer('nationality');
            $table->integer('ethnic_code');
            $table->integer('race_code');
            $table->integer('language');
            $table->date('date_of_birth');
            $table->string('blood_group', 20);
            $table->string('nid', 100);
            $table->string('passport', 100);
            $table->date('passport_expiry_date');
            $table->string('driving_licence', 100);
            $table->date('driving_licence_expiry_date');
            $table->string('father_name', 50);
            $table->string('mother_name', 50);
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
        Schema::dropIfExists('hrm_emp_personal_details');
    }
};
