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
        Schema::create('tbl_advance_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('customers');
            $table->integer('srv_id');
            $table->date('rec_date');
            $table->string('bill_month', 10);
            $table->double('bill_year');
            $table->double('amount');
            $table->double('discount');
            $table->integer('entry_by');
            $table->date('entry_date');
            $table->string('money_recipt', 100);
            $table->string('pay_type', 10);
            $table->integer('collection_id');
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
        Schema::dropIfExists('tbl_advance_bills');
    }
};
