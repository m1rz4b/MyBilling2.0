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
        Schema::create('mas_supplier_invoices', function (Blueprint $table) {
            $table->id(); //invoiceobjet_id
            $table->integer('invoice_number');
            $table->integer('bill_number');
            $table->integer('client_type');
            $table->date('invoice_date');
            $table->integer('client_id');
            $table->string('remarks',120)->default('');
            $table->double('vat')->default(0);
            $table->double('vatper')->default(0);
            $table->double('bill_amount')->default(0);
            $table->double('total_bill')->default(0);
            $table->double('collection_amnt')->default(0);
            $table->double('ait_adjustment')->default(0);
            $table->date('ait_adj_date');
            $table->double('vat_adjust_ment')->default(0);
            $table->date('vat_adjust_date');
            $table->double('other_adjustment')->default(0);
            $table->double('discount_amnt')->default(0);
            $table->date('discount_date');
            $table->string('comments',220);
            $table->char('receive_status',1)->default('');
            $table->integer('view_status',)->default('0');
            $table->string('invoice_cat',20);
            $table->string('other_add_item',120);
            $table->double('other_add_amount')->default(0);
            $table->double('adv_rec')->default(0);
            $table->date('next_inv_date');
            $table->string('cost_code',20);
            $table->integer('project_id',);
            $table->integer('journal_status');
            $table->integer('journal_id');
            $table->double('dscount_onpurchase')->default(0);
            $table->integer('office_id');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_supplier_invoices');
    }
};
