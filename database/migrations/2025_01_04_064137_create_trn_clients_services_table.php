<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trn_clients_services', function (Blueprint $table) {
            $table->id();  //Renamed from "srv_id"
            $table->unsignedBigInteger('customer_id')->nullable();  //Renamed from "client_id"
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('user_id', 150);  
            $table->string('password', 150);  //Renamed from "network_password"
            $table->unsignedBigInteger('bandwidth_plan_id')->nullable();  //Renamed from "bandwidth_plan"
            $table->foreign('bandwidth_plan_id')->references('id')->on('tbl_bandwidth_plans');
            $table->string('installation_date');  //Renamed from "inst_date"
            $table->string('remarks');  //new
            $table->string('type_of_connectivity');  //Renamed from "connectivity_id"
            $table->unsignedBigInteger('router_id')->nullable();  //Renamed from "router"
            $table->foreign('router_id')->references('id')->on('tbl_routers');
            $table->string('device');  //new
            $table->string('mac_address', 50);
            $table->string('ip_number', 50);
            $table->unsignedBigInteger('box_id')->nullable();  //new
            $table->foreign('box_id')->references('id')->on('boxes');
            $table->string('cable_req');  //new
            $table->string('no_of_core');  //new
            $table->string('core_color');  //new
            $table->string('fiber_code');  //new
            $table->unsignedBigInteger('tbl_bill_type_id')->nullable();  //Renamed from "bill_type"
            $table->foreign('tbl_bill_type_id')->references('id')->on('tbl_bill_types');
            $table->unsignedBigInteger('invoice_type_id')->nullable();  //Previously 'customer_types->billing_types'
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types');
            $table->string('bill_start_date');  //Renamed from "strat_date"
            $table->unsignedBigInteger('tbl_client_type_id')->nullable();  //Renamed from "client_type"
            $table->foreign('tbl_client_type_id')->references('id')->on('tbl_client_types');
            $table->string('monthly_bill');  //Renamed from "billing_month"
            $table->unsignedBigInteger('billing_status_id')->nullable();   //new
            $table->foreign('billing_status_id')->references('id')->on('billing_statuses');
            $table->unsignedBigInteger('tbl_status_type_id')->nullable();   //Renamed from 'cstatus'
            $table->foreign('tbl_status_type_id')->references('id')->on('tbl_status_types');
            $table->integer('include_vat')->default(0);  //new
            $table->integer('greeting_sms_sent')->default(0);  //new

            // Data Service/Other Service
            $table->mediumText('link_from');
            $table->mediumText('link_to');
            $table->string('bandwidth', 100);
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('tbl_units');  //Renamed from 'unit'
            $table->double('unit_qty');
            $table->double('vat_rate');
            $table->double('rate_amnt');
            $table->double('vat_amnt');

            // Cable TV
            $table->integer('number_of_tv');
            $table->integer('number_of_channel');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('tbl_districts');
            $table->unsignedBigInteger('srv_type_id')->nullable();  //Renamed from "service_type_id"
            $table->foreign('srv_type_id')->references('id')->on('tbl_srv_types');
            $table->unsignedBigInteger('vat_type_id')->nullable();
            $table->foreign('vat_type_id')->references('id')->on('tbl_vat_types');
            
            //Client control controller
            $table->date('block_date')->nullable();
            $table->integer('static_ip')->nullable();
            $table->unsignedBigInteger('block_reason_id')->nullable();  //Renamed from 'block_reason'
            $table->foreign('block_reason_id')->references('id')->on('block_reasons');

            $table->string('contact_person')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_email')->nullable();

            // $table->string('contract_person', 220)->nullable();
            // $table->string('address', 120)->nullable();
            // $table->string('address1', 120)->nullable();
            // $table->mediumText('area')->nullable();
            // $table->string('phone', 20)->nullable();
            // $table->string('mobile1', 20)->nullable();
            // $table->string('mobile2', 20)->nullable();
            // $table->string('email', 60)->nullable();
            // $table->integer('link_type')->nullable();
            // $table->string('conn_desc', 120)->nullable();
            // $table->integer('group_id')->nullable();
            // $table->integer('vat_display')->nullable();
            // $table->string('comments', 80)->nullable();
            // $table->dateTime('end_date')->nullable();
            // $table->dateTime('rate_change_date')->nullable();
            // $table->integer('pay_type')->nullable();
            // $table->string('atm_no', 20)->nullable();
            // $table->mediumText('remark')->nullable();
            // $table->integer('type')->nullable();
            // $table->integer('cable_type')->nullable();
            // $table->double('sales_price')->nullable();
            // $table->double('paid_amount')->nullable();
            // $table->string('ip_charge', 150)->nullable();
            // $table->integer('ip_mr_number')->nullable();
            // $table->string('mrn', 100)->nullable()->nullable();
            // $table->integer('client_type')->nullable()->index('client_type');
            // $table->string('ac_no')->nullable();
            // $table->integer('static_ip')->nullable();
            // $table->unsignedBigInteger('trn_clients_service_ratechange_id')->nullable();
            // $table->foreign('trn_clients_service_ratechange_id')->references('id')->on('trn_clients_service_ratechanges');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('trn_clients_services');
    }
};
