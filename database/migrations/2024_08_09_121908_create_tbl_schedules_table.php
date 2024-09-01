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
        Schema::create('tbl_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('sch_name', 100);
            $table->time('start_time');
            $table->time('end_time');
            $table->time('late_time');
            $table->time('begining_start');
            $table->time('begining_end');
            $table->time('out_start');
            $table->time('out_end');
            $table->integer('sat')->nullable();
            $table->integer('sun')->nullable();
            $table->integer('mon')->nullable();
            $table->integer('tues')->nullable();
            $table->integer('wed')->nullable();
            $table->integer('thurs')->nullable();
            $table->integer('fri')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tbl_schedule');
    }
};
