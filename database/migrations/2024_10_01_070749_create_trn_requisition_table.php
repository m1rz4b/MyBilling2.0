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
        Schema::create('trn_requisition', function (Blueprint $table) {
            $table->id();  //Renamed from 'trn_req_id'
            $table->integer('req_id');
            $table->integer('cat_id');
            $table->integer('prod_id');
            $table->integer('qty');
            $table->text('description');
            $table->integer('issued_qty');
            $table->double('pd_rate');
            $table->double('pd_price');
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
        Schema::dropIfExists('trn_requisition');
    }
};
