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
        Schema::create('mas_assets', function (Blueprint $table) {
            $table->id(); //assetobjectid
		    $table->string('description',120)->default('');
		    $table->string('gl_code',5)->default('');
		    $table->double('depreciation_rate')->default(0);
		    $table->double('ann_rate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_assets');
    }
};
