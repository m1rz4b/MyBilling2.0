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
        Schema::create('tbl_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_parent_id');
            $table->string('cat_name');
            $table->string('cate_code');
            $table->string('cat_description');
            $table->string('cat_image');
            $table->integer('level_id');
            $table->integer('act_status');
            $table->integer('cat_type_id');
            $table->string('glcode',10);
            $table->string('income_glcode',10);
            $table->string('expance_glcode',10);
            $table->string('depreciation_rate',10);
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
        Schema::dropIfExists('tbl_categories');
    }
};
