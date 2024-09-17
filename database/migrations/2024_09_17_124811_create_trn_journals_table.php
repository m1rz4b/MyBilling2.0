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
        Schema::create('trn_journals', function (Blueprint $table) {
            $table->id(); //recordid
            
            $table->bigInteger('journalid');
            $table->integer('companyid')->default('0');
            $table->string('slno',10)->default('');
            $table->string('glcode',5)->nullable()->default('NULL');
            $table->string('subglcode',15)->default('');
            $table->string('cost_code',5)->default('');
            $table->integer('lcno')->default('0');
            $table->double('amount')->default('0');
            $table->string('remarks',150)->default('');
            $table->string('ttype',10)->default('0');
            $table->double('dtype')->default('0');
            $table->double('running_dr')->default('0');
            $table->double('running_cr')->default('0');
            $table->integer('reconcile_status')->default('0');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_journals');
    }
};
