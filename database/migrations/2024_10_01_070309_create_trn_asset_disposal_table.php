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
        Schema::create('trn_asset_disposal', function (Blueprint $table) {
            $table->id();  //Renamed from 'assetid'
            $table->double('sales_amount')->default(0);
            $table->double('depreciation_adjust')->default(0);
            $table->date('sales_date')->nullable();
            $table->string('remarks', 220)->default('');
            $table->integer('journal_id');
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
        Schema::dropIfExists('trn_asset_disposal');
    }
};
