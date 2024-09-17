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
        Schema::create('mas_cost_centers', function (Blueprint $table) {
            $table->id();
            $table->integer('pid',)->default('0');
            $table->string('description',50)->default('');
            $table->string('cost_code',5)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_cost_centers');
    }
};
