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
        Schema::create('tbl_zone', function (Blueprint $table) {
            $table->id();
            $table->string('zone_name', 100);
            $table->string('zone_code', 100)->nullable();
            $table->integer('discount')->nullable();
            $table->double('advance_amount')->nullable();
            $table->date('advance_date')->nullable();
            $table->integer('distributor_status')->nullable();
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
        Schema::dropIfExists('tbl_zone');
    }
};
