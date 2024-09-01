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
        Schema::create('change_pppoe_to_hotspots', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('previous_ip');
            $table->string('current_ip');
            $table->string('static_ip');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_pppoe_to_hotspots');
    }
};
