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
        Schema::create('checkinout', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->dateTime('checktime');
            $table->string('checktype', 20);
            $table->integer('verifycode');
            $table->string('SN', 20)->nullable();
            $table->string('sensorid', 5)->nullable();
            $table->string('WorkCode', 20)->nullable();
            $table->string('Reserved', 20)->nullable();
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
        Schema::dropIfExists('checkinout');
    }
};
