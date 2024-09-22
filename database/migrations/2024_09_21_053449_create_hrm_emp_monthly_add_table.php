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
        Schema::create('hrm_emp_monthly_add', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->year('year');
            $table->integer('month');
            $table->integer('add_comp_id');
            $table->double('amnt');
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
        Schema::dropIfExists('hrm_emp_monthly_add');
    }
};
