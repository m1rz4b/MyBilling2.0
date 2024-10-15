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
        Schema::create('hrm_salary_advanced', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('date');
            $table->double('amount');
            $table->double('deduct_amount');
            $table->double('total_amount');
            $table->integer('no_of_installment');
            $table->double('emi');
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
        Schema::dropIfExists('hrm_salary_advanced');
    }
};
