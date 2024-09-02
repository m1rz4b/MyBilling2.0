<?php

namespace App\Http\Controllers;

use App\Models\TblSrvType;
use App\Models\TrnClientsService;
use App\Models\Menu;
use App\Models\TblUnit;
use App\Models\Customer;
use App\Models\TblBandwidthPlan;
use App\Models\TblCableType;
use App\Models\TblRouter;
use App\Models\Box;
use App\Models\TblBillType;
use App\Models\InvoiceType;
use App\Models\TblClientType;
use App\Models\BillingStatus;
use App\Models\TblStatusType;
use Illuminate\Http\Request;

class TrnClientsServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedCustomer = -1;
        $selectedCustomerStatus = -1;
        $menus = Menu::get();
        $units = TblUnit::select('id','unit_display')->orderBy('unit_display', 'asc')->get();
        $client_services = TrnClientsService::select(
            'trn_clients_services.*',
            'customers.id as cust_id', 
            'customers.customer_name', 
            'tbl_districts.name',
            'tbl_srv_types.srv_name',
            'tbl_vat_types.status_name',
            'tbl_status_types.inv_name',
            'tbl_bill_types.bill_type_name',
            'tbl_units.unit_display'
        )
        ->leftJoin('customers', 'customers.id', '=', 'trn_clients_services.customer_id')
        ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'trn_clients_services.district_id')
        ->leftJoin('tbl_srv_types', 'tbl_srv_types.id', '=', 'trn_clients_services.srv_type_id')
        ->leftJoin('tbl_vat_types', 'tbl_vat_types.id', '=', 'trn_clients_services.vat_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_units', 'tbl_units.id', '=', 'trn_clients_services.unit_id')
        ->get();

        $customers = Customer::select('id', 'customer_name','present_address')->orderBy('customer_name', 'desc')->get();
        $service_types = TblSrvType::select('id','srv_name')->orderBy('srv_name', 'asc')->get();
        $bandwidth_plans = TblBandwidthPlan::select('id','bandwidth_plan')->orderBy('id', 'desc')->get();
        $cable_types = TblCableType::select('id', 'cable_type')->orderBy('id', 'desc')->get();
        $routers = TblRouter::select('id', 'router_name')->orderBy('router_name', 'desc')->get();
        $boxes = Box::select('id', 'box_name')->orderBy('id', 'desc')->get();
        $bill_types = TblBillType::select('id', 'bill_type_name')->orderBy('bill_type_name', 'desc')->get();
        $invoice_types = InvoiceType::select('id', 'invoice_type_name')->orderBy('invoice_type_name', 'desc')->get();
        $client_types = TblClientType::get();
        $billing_statuses = BillingStatus::select('id', 'billing_status_name')->orderBy('billing_status_name', 'desc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'desc')->get();
        return view("pages.company.customers.services_info", compact(
            'menus', 
            'units',
            'client_services', 
            'customers', 
            'service_types', 
            'bandwidth_plans',
            'cable_types',
            'routers',
            'boxes', 
            'bill_types', 
            'invoice_types', 
            'client_types',
            'billing_statuses',
            'status_types',
            'selectedCustomer',
            'selectedCustomerStatus'
        ));
    }

    public function search(Request $request)
    {
        $selectedCustomer = $request->customer;
        $selectedCustomerStatus = $request->customer_status;

        $menus = Menu::get();
        $units = TblUnit::select('id','unit_display')->orderBy('unit_display', 'asc')->get();
        $client_services = TrnClientsService::select(
            'trn_clients_services.*',
            'customers.id as cust_id', 
            'customers.customer_name', 
            'tbl_districts.name',
            'tbl_srv_types.srv_name',
            'tbl_vat_types.status_name',
            'tbl_status_types.inv_name',
            'tbl_bill_types.bill_type_name',
            'tbl_units.unit_display'
        )
        ->leftJoin('customers', 'customers.id', '=', 'trn_clients_services.customer_id')
        ->leftJoin('tbl_districts', 'tbl_districts.id', '=', 'trn_clients_services.district_id')
        ->leftJoin('tbl_srv_types', 'tbl_srv_types.id', '=', 'trn_clients_services.srv_type_id')
        ->leftJoin('tbl_vat_types', 'tbl_vat_types.id', '=', 'trn_clients_services.vat_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_units', 'tbl_units.id', '=', 'trn_clients_services.unit_id');
        if ($selectedCustomer>-1) {
            $client_services->where('customers.id', $selectedCustomer);
        }
        if ($selectedCustomerStatus>-1) {
            $client_services->where('tbl_status_types.id', $selectedCustomerStatus);
        }
        $client_services = $client_services->get();

        $customers = Customer::select('id', 'customer_name','present_address')->orderBy('customer_name', 'desc')->get();
        $service_types = TblSrvType::select('id','srv_name')->orderBy('srv_name', 'asc')->get();
        $bandwidth_plans = TblBandwidthPlan::select('id','bandwidth_plan')->orderBy('id', 'desc')->get();
        $cable_types = TblCableType::select('id', 'cable_type')->orderBy('id', 'desc')->get();
        $routers = TblRouter::select('id', 'router_name')->orderBy('router_name', 'desc')->get();
        $boxes = Box::select('id', 'box_name')->orderBy('id', 'desc')->get();
        $bill_types = TblBillType::select('id', 'bill_type_name')->orderBy('bill_type_name', 'desc')->get();
        $invoice_types = InvoiceType::select('id', 'invoice_type_name')->orderBy('invoice_type_name', 'desc')->get();
        $client_types = TblClientType::get();
        $billing_statuses = BillingStatus::select('id', 'billing_status_name')->orderBy('billing_status_name', 'desc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'desc')->get();
        return view("pages.company.customers.services_info", compact(
            'menus', 
            'units',
            'client_services', 
            'customers', 
            'service_types', 
            'bandwidth_plans',
            'cable_types',
            'routers',
            'boxes', 
            'bill_types', 
            'invoice_types', 
            'client_types',
            'billing_statuses',
            'status_types',
            'selectedCustomer',
            'selectedCustomerStatus'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(request()->all());
        $monthly_bill = 0;
        $include_vat = 0;
        $bill_start_date = 0;
        $tbl_bill_type_id = 0;
        $tbl_status_type_id = 0;
        $remarks = 0;
        $greeting_sms_sent = 0;

        if ($request->srv_type_id == 1){
            $monthly_bill = $request->monthly_bill_data;
            $include_vat = $request->include_vat_data;
            $bill_start_date = $request->bill_start_date_data;
            $tbl_bill_type_id = $request->tbl_bill_type_id_data;
            $tbl_status_type_id = $request->tbl_status_type_id_data;
            $remarks = $request->remarks_data;
            $greeting_sms_sent = $request->greeting_sms_sent_data;
        } else if ($request->srv_type_id == 2) {
            $monthly_bill = $request->monthly_bill_broadband;
            $include_vat = $request->include_vat_broadband;
            $bill_start_date = $request->bill_start_date_broadband;
            $tbl_bill_type_id = $request->tbl_bill_type_id_broadband;
            $tbl_status_type_id = $request->tbl_status_type_id_broadband;
            $remarks = $request->remarks_broadband;
            $greeting_sms_sent = $request->greeting_sms_sent_broadband;
        } else {
            $monthly_bill = $request->monthly_bill_cable;
            $include_vat = $request->include_vat_cable;
            $bill_start_date = $request->bill_start_date_cable;
            $tbl_bill_type_id = $request->tbl_bill_type_id_cable;
            $tbl_status_type_id = $request->tbl_status_type_id_cable;
            $remarks = $request->remarks_cable;
            $greeting_sms_sent = $request->greeting_sms_sent_cable;
        }

        TrnClientsService::create([
            "srv_type_id" => ($request->srv_type_id == null) ? null : $request->srv_type_id,
            "link_from" =>  ($request->link_from == null) ? '' : $request->link_from,
            "link_to" =>  ($request->link_to == null) ? '' : $request->link_to,
            "bandwidth" =>  ($request->bandwidth == null) ? '' : $request->bandwidth,
            "unit_id" =>  ($request->unit_id == null) ? null : $request->unit_id,
            "unit_qty" =>  ($request->unit_qty == null) ? 0 : $request->unit_qty,
            "vat_rate" =>  ($request->vat_rate == null) ? 0 : $request->vat_rate,
            "rate_amnt" =>  ($request->rate_amnt == null) ? 0 : $request->rate_amnt,
            "vat_amnt" =>  ($request->vat_amnt == null) ? 0 : $request->vat_amnt,

            "customer_id" => $request->customer_id,
            "user_id" => ($request->user_id == null) ? '' : $request->user_id,
            "password" => ($request->password == null) ? '' : $request->password,
            "bandwidth_plan_id" => ($request->bandwidth_plan_id == null) ? null : $request->bandwidth_plan_id,
            "installation_date" => ($request->installation_date == null) ? '' : $request->installation_date,
            // "remarks" => ($request->remarks == null) ? '' : $request->remarks,
            "remarks" => $remarks,
            "type_of_connectivity" => ($request->type_of_connectivity == null) ? '' : $request->type_of_connectivity,
            "router_id" => ($request->router_id == null) ? null : $request->router_id,
            "device" => ($request->device == null) ? '' : $request->device,
            "mac_address" => ($request->mac_address == null) ? '' : $request->mac_address,
            "ip_number" => ($request->ip_number == null) ? '' : $request->ip_number,
            "box_id" => ($request->box_id == null) ? null : $request->box_id,
            "cable_req" => ($request->cable_req == null) ? '' : $request->cable_req,
            "no_of_core" => ($request->no_of_core == null) ? '' : $request->no_of_core,
            "core_color" => ($request->core_color == null) ? '' : $request->core_color,
            "fiber_code" => ($request->fiber_code == null) ? '' : $request->fiber_code,
            // "tbl_bill_type_id" => ($request->tbl_bill_type_id == null) ? 0 : $request->tbl_bill_type_id,
            "tbl_bill_type_id" => $tbl_bill_type_id,
            "invoice_type_id" => 1,
            "bill_start_date" => $bill_start_date,
            // "bill_start_date" => ($request->bill_start_date == null) ? '' : $request->bill_start_date,
            "tbl_client_type_id" => ($request->tbl_client_type_id == null) ? null : $request->tbl_client_type_id,
            // "monthly_bill" => ($request->monthly_bill == null) ? '' : $request->monthly_bill,
            "monthly_bill" => $monthly_bill,
            "billing_status_id" => ($request->billing_status_id == null) ? null : $request->billing_status_id,
            // "tbl_status_type_id" => ($request->tbl_status_type_id == null) ? 0 : $request->tbl_status_type_id,
            "tbl_status_type_id" => $tbl_status_type_id,
            // "include_vat" => ($request->include_vat == null) ? 0 : $request->include_vat,
            "include_vat" => $include_vat,
            // "greeting_sms_sent" => ($request->greeting_sms_sent == null) ? 0 : $request->greeting_sms_sent,
            "greeting_sms_sent" => $greeting_sms_sent,

            "number_of_tv" => ($request->number_of_tv == null) ? 0 : $request->number_of_tv,
            "number_of_channel" => ($request->number_of_channel == null) ? 0 : $request->number_of_channel,
        ]);

        return redirect('/services')->with('success', 'Service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrnClientsService $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrnClientsService $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $service)
    {
        // dd($request);
        $monthly_bill = 0;
        $include_vat = 0;
        $bill_start_date = 0;
        $tbl_bill_type_id = 0;
        $tbl_status_type_id = 0;
        $remarks = 0;
        $greeting_sms_sent = 0;

        if ($request->srv_type_id == 1){
            $monthly_bill = $request->monthly_bill_data;
            $include_vat = $request->include_vat_data;
            $bill_start_date = $request->bill_start_date_data;
            $tbl_bill_type_id = $request->tbl_bill_type_id_data;
            $tbl_status_type_id = $request->tbl_status_type_id_data;
            $remarks = $request->remarks_data;
            $greeting_sms_sent = $request->greeting_sms_sent_data;
        } else if ($request->srv_type_id == 2) {
            $monthly_bill = $request->monthly_bill_broadband;
            $include_vat = $request->include_vat_broadband;
            $bill_start_date = $request->bill_start_date_broadband;
            $tbl_bill_type_id = $request->tbl_bill_type_id_broadband;
            $tbl_status_type_id = $request->tbl_status_type_id_broadband;
            $remarks = $request->remarks_broadband;
            $greeting_sms_sent = $request->greeting_sms_sent_broadband;
        } else {
            $monthly_bill = $request->monthly_bill_cable;
            $include_vat = $request->include_vat_cable;
            $bill_start_date = $request->bill_start_date_cable;
            $tbl_bill_type_id = $request->tbl_bill_type_id_cable;
            $tbl_status_type_id = $request->tbl_status_type_id_cable;
            $remarks = $request->remarks_cable;
            $greeting_sms_sent = $request->greeting_sms_sent_cable;
        }

        $services = TrnClientsService::find($service);
        // $services = TrnClientsService::where('srv_type_id', $request->srv_type_id)->where('customer_id', $request->customer_id) ->first();
        
        $services->srv_type_id = ($request->srv_type_id == null) ? null : $request->srv_type_id;
        $services->link_from = ($request->link_from == null) ? '' : $request->link_from;
        $services->link_to = ($request->link_to == null) ? '' : $request->link_to;
        $services->bandwidth = ($request->bandwidth == null) ? '' : $request->bandwidth;
        $services->unit_id = ($request->unit_id == null) ? null : $request->unit_id;
        $services->unit_qty = ($request->unit_qty == null) ? 0 : $request->unit_qty;
        $services->vat_rate = ($request->vat_rate == null) ? 0 : $request->vat_rate;
        $services->rate_amnt = ($request->rate_amnt == null) ? 0 : $request->rate_amnt;
        $services->rate_amnt = ($request->rate_amnt == null) ? 0 : $request->rate_amnt;

        $services->user_id = ($request->user_id == null) ? '' : $request->user_id;
        $services->password = ($request->password == null) ? '' : $request->password;
        $services->bandwidth_plan_id = ($request->bandwidth_plan_id == null) ? null : $request->bandwidth_plan_id;
        $services->installation_date = ($request->installation_date == null) ? '' : $request->installation_date;
        // $services->remarks = ($request->remarks == null) ? '' : $request->remarks;
        $services->remarks = $remarks;
        $services->type_of_connectivity = ($request->type_of_connectivity == null) ? '' : $request->type_of_connectivity;
        $services->router_id = ($request->router_id == null) ? null : $request->router_id;
        $services->device = ($request->device == null) ? '' : $request->device;
        $services->mac_address = ($request->mac_address == null) ? '' : $request->mac_address;
        $services->ip_number = ($request->ip_number == null) ? '' : $request->ip_number;
        $services->box_id = ($request->box_id == null) ? null : $request->box_id;
        $services->cable_req = ($request->cable_req == null) ? '' : $request->cable_req;
        $services->no_of_core = ($request->no_of_core == null) ? '' : $request->no_of_core;
        $services->core_color = ($request->core_color == null) ? '' : $request->core_color;
        $services->fiber_code = ($request->fiber_code == null) ? '' : $request->fiber_code;
        // $services->tbl_bill_type_id = ($request->tbl_bill_type_id == null) ? 0 : $request->tbl_bill_type_id;
        $services->tbl_bill_type_id = $tbl_bill_type_id;
        $services->invoice_type_id = 1;
        // $services->bill_start_date = ($request->bill_start_date == null) ? '' : $request->bill_start_date;
        $services->bill_start_date = $bill_start_date;
        $services->tbl_client_type_id = ($request->tbl_client_type_id == null) ? null : $request->tbl_client_type_id;
        // $services->monthly_bill = ($request->monthly_bill == null) ? '' : $request->monthly_bill;
        $services->monthly_bill = $monthly_bill;
        $services->billing_status_id = ($request->billing_status_id == null) ? null : $request->billing_status_id;
        // $services->tbl_status_type_id = ($request->tbl_status_type_id == null) ? 0 : $request->tbl_status_type_id;
        $services->tbl_status_type_id = $tbl_status_type_id;
        // $services->include_vat = ($request->include_vat == null) ? 0 : $request->include_vat;
        $services->include_vat = $include_vat;
        // $services->greeting_sms_sent = ($request->greeting_sms_sent == null) ? 0 : $request->greeting_sms_sent;
        $services->greeting_sms_sent = $greeting_sms_sent;

        $services->number_of_tv = ($request->number_of_tv == null) ? 0 : $request->number_of_tv;
        $services->number_of_channel = ($request->number_of_channel == null) ? 0 : $request->number_of_channel;
        $services->save();

        return redirect('/services')->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrnClientsService $service)
    {
        //
    }
}
