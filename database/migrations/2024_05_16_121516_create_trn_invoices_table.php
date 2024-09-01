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
        Schema::create('trn_invoices', function (Blueprint $table) {
            $table->id();
            // $table->integer('trninvoiceobject_id', true);
            $table->integer('invoiceobject_id')->default(0);
            $table->integer('serv_id');
            $table->integer('client_id');
            $table->integer('billing_year');
            $table->integer('billing_month');
            $table->string('unit', 50);
            $table->integer('unitqty');
            $table->double('rate');
            $table->double('vat');
            $table->integer('billingdays');
            $table->date('from_date');
            $table->date('to_date');
            $table->double('camnt');
            $table->double('cvat');
            $table->double('total');
            $table->double('collection_amnt')->default(0);
            $table->double('discount_amnt')->default(0);
            $table->date('discount_date')->nullable();
            $table->text('discount_comments')->nullable();
            $table->string('entry_by', 25);
            $table->date('entry_date');
            $table->string('comments', 220)->nullable();
            $table->integer('reseller_id');
            $table->double('share_rate');
            $table->double('extra_bill')->nullable();
            $table->double('arrar')->nullable();
            $table->date('change_date');
            $table->string('punit', 50);
            $table->integer('punitqty');
            $table->double('prate');
            $table->double('pvate');
            $table->string('c_type', 30);
            $table->double('pshare_rate')->default(0);
            $table->double('extra_share_rate');
            $table->integer('package_id')->nullable();
            $table->integer('ppackage_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('trn_invoices');
    }
};
