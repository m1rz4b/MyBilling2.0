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
        Schema::create('trn_clients_service_ratechanges', function (Blueprint $table) {
            $table->id();  //Renamed from "srv_id"
            $table->unsignedBigInteger('customer_id')->nullable();  //Renamed from "client_id"
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->double('punit');
            $table->double('punit_qty')->default(0);
            $table->double('prate');
            $table->double('pvat');
            $table->dateTime('rate_change_date');
            $table->double('cunit');
            $table->double('cunit_qty')->default(0);
            $table->double('crate');
            $table->double('cvat');
            $table->unsignedBigInteger('trn_clients_service_id')->nullable();  //Renamed from "service_id"
            $table->foreign('trn_clients_service_id')->references('id')->on('trn_clients_services');
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
        Schema::dropIfExists('trn_clients_service_ratechanges');
    }
};
