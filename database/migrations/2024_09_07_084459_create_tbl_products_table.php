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
        Schema::create('tbl_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');  
            $table->foreign('cat_id')->references('id')->on('tbl_categories');
            $table->Integer('brand_id');
            $table->Integer('unit_type');
            $table->string('pd_name');
            $table->string('pd_description');
            $table->decimal('pd_price');
            $table->decimal('pd_prev_price');
            $table->decimal('pd_price_comments');
            $table->decimal('pd_qty');
            $table->string('pd_image');
            $table->string('pd_thumbnail');
            $table->string('product_detail');
            $table->string('product_specification');
            $table->string('product_warranty');
            $table->date('pd_date');
            $table->date('pd_last_update');
            $table->integer('reward_point');
            $table->integer('item_type');
            $table->integer('pdtcode');
            $table->integer('model_id');
            $table->integer('capacity_id');
            $table->integer('type_id');
            $table->string('sku',25);
            $table->integer('reorder_lev');
            $table->integer('product_serials');
            $table->integer('warranty_period');
            $table->integer('warranty_lifetime');
            $table->integer('generate_sl');
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
        Schema::dropIfExists('tbl_products');
    }
};
