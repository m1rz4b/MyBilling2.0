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
        Schema::create('mas_asset_dep_setups', function (Blueprint $table) {
            $table->id(); //asset_glcode
            
            $table->string('cost_code',5)->default('');
            $table->string('asset_dep_glcode',5)->default('');
            $table->string('asset_acm_glcode',5)->default('');
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
        Schema::dropIfExists('mas_asset_dep_setups');
    }
};
