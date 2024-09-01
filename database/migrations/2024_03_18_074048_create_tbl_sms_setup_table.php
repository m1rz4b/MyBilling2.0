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
        Schema::create('tbl_sms_setup', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('sms_url');
            $table->text('submit_param');
            $table->text('return_param')->nullable();
            $table->integer('return_value_type')->nullable();
            $table->string('type', 20);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tbl_sms_setup');
    }
};
