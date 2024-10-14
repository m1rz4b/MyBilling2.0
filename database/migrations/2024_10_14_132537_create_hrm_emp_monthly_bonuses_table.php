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
        Schema::create('hrm_emp_monthly_bonus', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->year('year');
            $table->integer('month');
            $table->double('basic');
            $table->double('bonus');
            $table->double('adv_adjust');
            $table->double('bonus_per');
            $table->integer('jv_status');
            $table->integer('jv_id');
            $table->integer('payment_mode');
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
        Schema::dropIfExists('hrm_emp_monthly_bonus');
    }
};
