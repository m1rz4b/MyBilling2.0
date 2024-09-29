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
        Schema::create('employee_leave_ledger', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->year('year');
            $table->integer('leave_type');
            $table->double('allowed')->nullable();
            $table->double('consumed')->nullable();
            $table->double('carry')->nullable();
            $table->double('total');

            $table->unique(['employee_id', 'year', 'leave_type'], 'employee_id');
            $table->unique(['employee_id', 'year', 'leave_type'], 'employee_id_2');
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
        Schema::dropIfExists('employee_leave_ledger');
    }
};
