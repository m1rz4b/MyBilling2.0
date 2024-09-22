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
        Schema::create('hrm_add_comp', function (Blueprint $table) {
            $table->id();
            $table->string('add_comp_name', 100);
            $table->integer('type');
            $table->double('percent');
            $table->double('amnt');
            $table->string('gl_code', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_add_comp');
    }
};
