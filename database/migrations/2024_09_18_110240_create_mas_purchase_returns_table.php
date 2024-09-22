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
        Schema::create('mas_purchase_returns', function (Blueprint $table) {
            $table->id(); //invoiceobjet_id
            $table->integer('invoice_number');
            $table->integer('bill_number');
            $table->integer('client_type');
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('remarks', 120)->default('');
            $table->double('vat')->default(0);
            $table->double('vatper');
            $table->double('bill_amount');
            $table->double('total_bill')->default(0);
            $table->double('collection_amnt');
            $table->double('ait_adjustment');
            $table->date('ait_adj_date');
            $table->double('vat_adjust_ment');
            $table->date('vat_adjust_date');
            $table->double('other_adjustment');
            $table->double('discount_amnt');
            $table->date('discount_date');
            $table->string('comments', 220);
            $table->char('receive_status', 1)->default('');
            $table->integer('view_status')->default(0);
            $table->string('invoice_cat', 20);
            $table->string('other_add_item', 120);
            $table->double('other_add_amount');
            $table->double('adv_rec');
            $table->date('next_inv_date');
            $table->integer('project_id');
            $table->integer('journal_status');
            $table->integer('journal_id');
            $table->integer('mas_sup_inv_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_purchase_returns');
    }
};
