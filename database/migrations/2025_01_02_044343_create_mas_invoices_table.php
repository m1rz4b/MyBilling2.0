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
        Schema::create('mas_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_number');
            $table->integer('bill_number');
            $table->date('invoice_date')->nullable();
            $table->date('invoice_period');
            $table->integer('client_id');
            $table->string('remarks', 120)->default('');
            $table->double('cur_arrear');
            $table->double('pre_arrear');
            $table->double('vatper');
            $table->double('vat')->default(0);
            $table->double('bill_amount');
            $table->double('total_bill')->default(0);
            $table->double('avat')->nullable();
            $table->double('abill_amount')->nullable();
            $table->double('atotal_bill')->nullable();
            $table->double('collection_amnt')->nullable();
            $table->double('ait_adjustment')->nullable();
            $table->date('ait_adj_date')->nullable();
            $table->double('vat_adjust_ment')->nullable();
            $table->date('vat_adjust_date');
            $table->double('other_adjustment');
            $table->double('discount_amnt');
            $table->date('discount_date');
            $table->double('downtimeadjust');
            $table->string('comments', 220)->nullable();
            $table->integer('invoiceobjet_id_pro');
            $table->char('receive_status', 1)->default('');
            $table->integer('view_status')->default(0);
            $table->string('entry_by', 10)->default('');
            $table->date('entry_date')->nullable();
            $table->string('update_by', 10)->default('');
            $table->date('update_date')->nullable();
            $table->string('invoice_cat', 20);
            $table->string('other_add_item', 120);
            $table->double('other_add_amount');
            $table->double('adv_rec');
            $table->string('unit', 250);
            $table->string('ip_number', 100);
            $table->double('rate_amnt');
            $table->integer('client_type');
            $table->date('next_inv_date');
            $table->integer('project_id');
            $table->integer('journal_status');
            $table->integer('journal_id');
            $table->string('work_order', 50)->nullable();
            $table->date('work_order_date')->nullable();
            $table->date('last_col_date')->nullable();
            $table->double('advrec');
            $table->integer('serv_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('full_pay');
            $table->integer('invoice_cat_id');
            $table->double('discount_onsale');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('tbl_invoice_cat_id');
            $table->foreign('tbl_invoice_cat_id')->references('id')->on('invoice_types');
            $table->unsignedBigInteger('tbl_srv_type_id');
            $table->foreign('tbl_srv_type_id')->references('id')->on('tbl_srv_types');
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
        Schema::dropIfExists('mas_invoices');
    }
};
