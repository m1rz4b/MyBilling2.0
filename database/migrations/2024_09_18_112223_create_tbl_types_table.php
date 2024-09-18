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
        Schema::create('tbl_types', function (Blueprint $table) {
            $table->id(); //type_id
            $table->integer('cat_id');
            $table->integer('brand_id');
            $table->string('type_name',30)->default('');
            $table->text('tp_description');
            $table->string('identefire_code_type',3)->nullable();
            $table->text('type_detail');
            $table->datetime('tp_date');
            $table->datetime('tp_last_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_types');
    }
};
