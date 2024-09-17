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
        Schema::create('mas_asset_dep_jvs', function (Blueprint $table) {
            $table->id(); //jv_no
            $table->integer('proc_month'); 
            $table->integer('proc_year'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_asset_dep_jvs');
    }
};
