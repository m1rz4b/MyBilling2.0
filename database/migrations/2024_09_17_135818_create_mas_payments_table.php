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
        Schema::create('mas_payments', function (Blueprint $table) {
            $table->id(); //collection_id
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->date('collection_date');
            $table->string('money_receipt',20);
            $table->string('pay_type',1);
            $table->integer('bank_id');
            $table->string('cheque_no',30);
            $table->date('cheque_date')->nullable();
            $table->double('coll_amount')->default(0);
            $table->string('remarks');
            $table->integer('coll_by');
            $table->integer('app_stat');
            $table->integer('app_by');
            $table->date('app_date');
            $table->integer('adv_stat');
            $table->integer('journalno');
            $table->double('discount')->default(0);
            $table->double('advance_adjust')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_payments');
    }
};
