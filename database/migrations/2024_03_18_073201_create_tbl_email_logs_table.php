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
        Schema::create('tbl_email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email', 150);
            $table->text('email_body');
            $table->text('return_message');
            $table->unsignedBigInteger('from_email');
            $table->foreign('from_email')->references('id')->on('tbl_email_setup');
            $table->integer('snder_id');
            $table->string('email_status', 11);
            $table->dateTime('date_time');
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
        Schema::dropIfExists('tbl_email_logs');
    }
};
