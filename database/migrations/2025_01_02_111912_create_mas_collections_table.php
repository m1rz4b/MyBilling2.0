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
        Schema::create('mas_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Foreign key (adjust for your actual client table)
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->date('collection_date');
            $table->string('money_receipt', 100);
            $table->string('pay_type', 1);
            $table->unsignedInteger('bank_id')->nullable(); // Foreign key (adjust for your actual bank table)
            $table->string('cheque_no', 30)->nullable();
            $table->date('cheque_date')->nullable();
            $table->double('coll_amount'); 
            $table->string('remarks', 255)->nullable();
            $table->unsignedInteger('coll_by')->nullable(); // Foreign key (adjust for your user table)
            // $table->unsignedInteger('entry_by'); // Foreign key (adjust for your user table)
            // $table->date('entry_date');
            $table->integer('app_stat')->nullable();
            $table->unsignedInteger('app_by')->nullable();// Foreign key (adjust for your user table)
            $table->date('app_date')->nullable();
            $table->integer('adv_stat')->nullable();
            $table->double('cur_arrear')->nullable();
            $table->double('vatadjust')->nullable();
            $table->double('discoun_amnt')->nullable();
            $table->double('aitadjust')->nullable();
            $table->double('downtimeadjust')->nullable();
            $table->double('adv_rec')->nullable();;
            $table->unsignedInteger('journal_id')->nullable(); // Foreign key (adjust for your journal table)
            $table->string('transaction_id', 100)->nullable();
            $table->integer('online_plat_from')->nullable();
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
        Schema::dropIfExists('mas_collections');
    }
};
