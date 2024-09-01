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
        Schema::create('hrm_increments', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->integer('month');
            $table->integer('year');
            $table->double('previous_gross');
            $table->double('increment_percent');
            $table->double('increment_amount');
            $table->double('current_gross');
            $table->integer('increment_type');
            $table->dateTime('entry_date');
            $table->integer('entry_by');
            $table->integer('administrative_status');
            $table->integer('administrative_by');
            $table->dateTime('administrative_date');
            $table->integer('approve_status');
            $table->dateTime('approve_date');
            $table->integer('approve_by');
            $table->unique(['emp_id', 'month', 'year'], 'emp_id');
            $table->integer('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_increments');
    }
};
