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
        Schema::create('trn_purchase_return', function (Blueprint $table) {
            $table->id();
            $table->integer('invoiceobject_id');
            $table->integer('sl_no');
            $table->integer('cat_id');
            $table->integer('prod_id');
            $table->string('prod_description', 220);
            $table->integer('client_id');
            $table->integer('billing_year');
            $table->integer('billing_month');
            $table->string('model', 220);
            $table->string('location', 220);
            $table->double('rate');
            $table->double('qty');
            $table->string('unit', 20);
            $table->double('vat');
            $table->double('total');
            $table->string('entry_by', 25);
            $table->date('entry_date');
            $table->string('update_by', 25);
            $table->date('update_date');
            $table->integer('inv_journal_id');
            $table->integer('journal_status');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_purchase_return');
    }
};
