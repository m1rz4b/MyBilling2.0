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
        Schema::create('trn_customer_returns', function (Blueprint $table) {
            $table->id(); //project_id
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('project_name', 256);
            $table->string('contract_person', 220);
            $table->string('address', 120);
            $table->string('address1', 120);
            $table->text('area');
            $table->integer('district');
            $table->string('phone', 20);
            $table->string('mobile1', 20);
            $table->string('mobile2', 20);
            $table->string('email', 60);
            $table->string('comments', 80);
            $table->double('rate');
            $table->double('vat');
            $table->date('strat_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('rate_change_date');
            $table->integer('pay_type');
            $table->integer('active_statust');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_customer_returns');
    }
};