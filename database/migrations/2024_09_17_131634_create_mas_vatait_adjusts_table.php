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
        Schema::create('mas_vatait_adjusts', function (Blueprint $table) {
            $table->id(); //vataitadjust_id
            $table->integer('serv_id',);
            $table->integer('client_Id',);
            $table->integer('masinvoiceobject_id');
            $table->date('adjust_date');
            $table->double('vat');
            $table->double('ait');
            $table->integer('journal_id');
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
        Schema::dropIfExists('mas_vatait_adjusts');
    }
};
