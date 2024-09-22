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
        Schema::create('mas_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',15);
            $table->string('clients_name',120);
            $table->integer('cstatus',)->nullable();
            $table->integer('client_type',);
            $table->string('company_name',120);
            $table->string('contract_person',220);
            $table->string('contract_person1',70);
            $table->text('address');
            $table->text('address1');
            $table->string('area',120);
            $table->integer('district_id',);
            $table->string('phone',120);
            $table->string('mobile1',20);
            $table->string('mobile2',20);
            $table->string('email',50);
            $table->string('web_address',120);
            $table->integer('business_type',);
            $table->integer('sale_by',);
            $table->integer('billing_by',);
            $table->integer('vat_status',);
            $table->date('status_date')->nullable();
            $table->string('comments');
            
            $table->integer('invoice_type');
            $table->integer('invoice_scheme');
            $table->double('discount');
            
            $table->string('other_add_item',120);
            $table->double('other_add_amount');
            

            $table->integer('supp_type',);
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
        Schema::dropIfExists('mas_suppliers');
    }
};
