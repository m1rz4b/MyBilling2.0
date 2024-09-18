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
        Schema::create('trn_asset_deprecations', function (Blueprint $table) {
            $table->id();
            $table->integer('assetid')->default('0');
            $table->integer('proc_year')->default('0');
            $table->integer('proc_month')->default('0');
            $table->double('opening_cost')->default('0');
            $table->double('addition_cost')->default('0');
            $table->double('sales_adjust')->default('0');
            $table->double('total_cost')->default('0');
            $table->double('opening_depreciation')->default('0');
            $table->double('depreciation_rate')->default('0');
            $table->double('current_depreciation')->default('0');
            $table->double('dep_for_month')->default('0');
            $table->double('depreication_adjust')->default('0');
            $table->double('total_depreciation')->default('0');
            $table->double('wdv')->default('0');
            $table->date('proc_date')->nullable();
            $table->string('proc_by',10)->default('');
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
        Schema::dropIfExists('trn_asset_deprecations');
    }
};
