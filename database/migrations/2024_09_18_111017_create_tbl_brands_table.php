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
        Schema::create('tbl_brands', function (Blueprint $table) {
            $table->id(); //brand_id
            $table->string('brand_display', 10);
            $table->string('brand_detail', 30);
            $table->text('brand_remarks')->nullable();
            $table->string('brand_user', 20)->nullable();
            $table->string('brand_pass', 20)->nullable();
            $table->string('identefire_code_brand', 4);
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
        Schema::dropIfExists('tbl_brands');
    }
};
