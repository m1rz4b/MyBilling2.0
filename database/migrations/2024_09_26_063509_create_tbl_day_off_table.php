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
        Schema::create('tbl_day_off', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('off_date');
            $table->integer('entry_by');
            $table->dateTime('entry_date');
            $table->unique(['emp_id', 'off_date'], 'emp_id');
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
        Schema::dropIfExists('tbl_day_off');
    }
};
