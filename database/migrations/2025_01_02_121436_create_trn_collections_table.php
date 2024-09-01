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
        Schema::create('trn_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id')->default(0); 
            $table->foreign('collection_id')->references('id')->on('mas_collections')->onDelete('cascade');
            $table->unsignedBigInteger('serv_id');
            $table->unsignedBigInteger('masinvoiceobject_id'); 
            $table->integer('billing_year');
            $table->integer('billing_month');
            $table->double('collamnt');
            $table->date('collection_date');
            $table->unsignedBigInteger('client_Id'); 
            $table->foreign('client_Id')->references('id')->on('customers')->onDelete('cascade'); 
            
          
            $table->double('vatadjust');
            $table->double('discoun_amnt');
            $table->double('aitadjust');
            $table->double('downtimeadjust');
            $table->double('adv_rec'); 
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            // Foreign keys (Assuming tables exist)
            
             
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_collections');
    }
};
