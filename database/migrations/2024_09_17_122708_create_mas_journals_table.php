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
        Schema::create('mas_journals', function (Blueprint $table) {
            $table->id(); //journalid
            $table->integer('journalno',)->default('0');
            $table->string('journaltype',15)->default('');
            $table->date('journaldate');
            $table->integer('lcno')->default('0');
            $table->string('billno',10)->default('');
            $table->string('moneyreceiptno',15)->default('');
            $table->date('moneyreceiptdate');
            $table->string('trantype',15)->default('');
            $table->string('paytype',15)->default('');
            $table->integer('bankid',)->default('0');
            $table->string('branchid',15)->default('');
            $table->integer('accountno')->default('0');
            $table->string('chequeno',15)->default('');
            $table->date('chequedate')->nullable();
            $table->string('partyid',100)->default('');
            $table->string('supplierid',5)->default('');
            $table->integer('project_id');
            $table->integer('companyid',)->default('0');
            $table->string('remarks',200)->default('');
            $table->string('payto',100)->default('');
            $table->integer('journal_status',)->default('0');
            $table->integer('tobankid')->nullable();
            $table->integer('toaccountno')->nullable();
            $table->integer('emp_id');
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
        Schema::dropIfExists('mas_journals');
    }
};
