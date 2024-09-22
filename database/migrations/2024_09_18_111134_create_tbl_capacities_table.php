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
        Schema::create('tbl_capacities', function (Blueprint $table) {
            $table->id(); //capacity_id
            $table->integer('cat_id')->default(0);
            $table->integer('brand_id');
            $table->string('capacity_name',30)->default('');
            $table->text('cp_description');
            $table->string('identefire_code_capacity',3);
            $table->text('capacity_detail');
            $table->datetime('cp_date');
            $table->datetime('cp_last_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_capacities');
    }
};
