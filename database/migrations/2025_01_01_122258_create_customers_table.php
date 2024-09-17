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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            // $table->string('user_id')->nullable();
            $table->string('customer_name');  //Renamed from "clients_name"
            $table->string('father_or_husband_name');  //Renamed from "father_husband_name"
            $table->string('mother_name');  //new
            $table->integer('gender');
            $table->string('blood_group');
            $table->string('date_of_birth');
            $table->string('reg_form_no');  //new
            $table->string('occupation');
            $table->string('vat_status');
            $table->string('nid_number');
            $table->string('email');
            $table->string('fb_id');
            $table->string('mobile1');
            $table->string('mobile2');
            $table->string('phone');
            $table->string('road_no');
            $table->string('house_flat_no');
            $table->integer('area_id');  //Renamed from "area"
            $table->integer('district_id');
            $table->integer('upazila_id');  //Renamed from "thana"
            $table->unsignedBigInteger('tbl_zone_id');  //Renamed from "zone"
            $table->foreign('tbl_zone_id')->references('id')->on('tbl_zone');
            $table->unsignedBigInteger('subzone_id');  //new
            $table->foreign('subzone_id')->references('id')->on('sub_zones');
            $table->string('latitude');  //new
            $table->string('longitude');  //new
            $table->string('present_address');  //Renamed from "address"
            $table->string('permanent_address');  //Renamed from "address1"
            $table->string('remarks');  //Renamed from "comments"
            $table->integer('business_type_id');  //Renamed from "business_type"
            $table->integer('connection_employee_id');  //new
            $table->string('reference_by');  //new
            $table->string('contract_person');
            $table->string('profile_pic');  //Renamed from "client_img"
            $table->string('nid_pic');  //Renamed from "nid_img"
            $table->string('reg_form_pic');  //new
            $table->string('account_no')->nullable();  //Previously 'ac_no'
            $table->unsignedBigInteger('tbl_client_category_id');  //Previously 'client_type'
            $table->foreign('tbl_client_category_id')->references('id')->on('tbl_client_categories');
            $table->integer('sub_office_id');  //new
            $table->integer('reseller_id')->default(0);  //new
            $table->integer('distributor_master')->default(0);  //new

            // $table->unsignedBigInteger('trn_clients_service_id')->nullable();  //new
            // $table->foreign('trn_clients_service_id')->references('id')->on('trn_clients_services');
            // $table->unsignedBigInteger('tbl_client_type_id');  //new
            // $table->foreign('tbl_client_type_id')->references('id')->on('tbl_client_types');
            // $table->unsignedBigInteger('tbl_status_type_id')->nullable();  //new
            // $table->foreign('tbl_status_type_id')->references('id')->on('tbl_status_types');
            // $table->unsignedBigInteger('bandwidth_plan_id')->nullable();  //Renamed from "bandwidth_plan"
            // $table->foreign('bandwidth_plan_id')->references('id')->on('tbl_bandwidth_plans');
            // $table->unsignedBigInteger('router_id');  //Renamed from "router"
            // $table->foreign('router_id')->references('id')->on('tbl_routers');
            // $table->unsignedBigInteger('trn_clients_service_ratechange_id')->nullable();  //new
            // $table->foreign('trn_clients_service_ratechange_id')->references('id')->on('trn_clients_service_ratechanges');
            
            // $table->string('user_id', 150);  //Renamed from "client_id"
            // $table->string('password', 150);  //Renamed from "network_password"
            // $table->string('fiber_code');  //new
            // $table->string('core_color');  //new
            // $table->integer('box_id');  //new
            // $table->string('cable_req');  //new
            // $table->string('no_of_core');  //new
            // $table->string('device');  //new
            // $table->string('mac_address', 50);
            // $table->string('ip_number', 50);
            // $table->string('type_of_connectivity');  //Renamed from "connectivity_id"
            // $table->string('bill_start_date');  //Renamed from "start_date"
            // $table->string('installation_date');  //Renamed from "expiry_date"
            // $table->string('monthly_bill');  //new
            // $table->integer('tbl_bill_type_id');  //new
            // $table->integer('billing_status_id');  //new
            // $table->unsignedBigInteger('invoice_type_id');  //Previously 'customer_types->billing_types'
            // $table->foreign('invoice_type_id')->references('id')->on('invoice_types');
            // $table->string('include_vat')->default(0);  //new
            // $table->integer('greeting_sms_sent')->default(0);  //new
            // $table->date('block_date')->nullable();
            // $table->unsignedBigInteger('block_reason_id');
            // $table->foreign('block_reason_id')->references('id')->on('block_reasons');
            // $table->unsignedBigInteger('radcheck_id');
            // $table->foreign('radcheck_id')->references('id')->on('radchecks');
            // $table->unsignedBigInteger('tbl_srv_type_id');
            // $table->foreign('tbl_srv_type_id')->references('id')->on('tbl_srv_types');
            $table->unsignedBigInteger('tbl_bill_cycle_id')->nullable();  //new
            $table->foreign('tbl_bill_cycle_id')->references('id')->on('tbl_bill_cycles');
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
        Schema::dropIfExists('customers');
    }
};
