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
        Schema::create('mas_latestjournalnumbers', function (Blueprint $table) {
            
            $table->integer('JV')->default(0);
            $table->integer('DR')->default(0);
            $table->integer('CR')->default(0);
            $table->integer('TR')->nullable()->default(0);
            $table->integer('vat_del_challan')->default(0);
            $table->integer('vat_challan')->default(0);
            $table->integer('get_pass')->default(0);
            $table->integer('vat_debitno');
            $table->integer('vat_credit_no');
            $table->integer('row_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mas_latestjournalnumbers');
    }
};
