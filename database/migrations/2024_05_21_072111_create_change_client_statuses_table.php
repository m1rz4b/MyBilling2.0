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
        Schema::create('change_client_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('block_reason');
            $table->string('exp_date');
            $table->string('previous_status');
            $table->string('current_status');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_client_statuses');
    }
};
