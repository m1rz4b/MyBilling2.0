<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('change_pass_ip_macs', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('previous_pass');
            $table->string('current_pass');
            $table->string('previous_ip');
            $table->string('current_ip');
            $table->string('previous_mac');
            $table->string('current_mac');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_pass_ip_macs');
    }
};
