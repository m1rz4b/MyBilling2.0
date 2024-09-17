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
        Schema::create('trn_banks', function (Blueprint $table) {
            $table->id(); //account_object_id
            $table->integer('bank_id',)->default('0');
            $table->string('account_no',100)->default('');
            $table->string('branch',120)->default('');
            $table->string('contract_person',120)->default('');
            $table->string('address1',120)->default('');
            $table->string('address2',120)->default('');
            $table->string('phone',20)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_banks');
    }
};
