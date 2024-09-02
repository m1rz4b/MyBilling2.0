<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Box;
use App\Models\MasEmployee;
use App\Models\TblRouter;
use App\Models\SubZone;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Models\TblStatusType;
use App\Models\Menu;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\BillingStatus;
use App\Models\BusinessType;
use App\Models\TblDistrict;
use App\Models\Upazila;
use App\Models\TblZone;
use App\Models\TblBandwidthPlan;
use App\Models\TblClientType;
use App\Models\TblBillType;
use App\Models\InvoiceType;
use App\Models\TblClientCategory;
use App\Models\TblSuboffice;
use App\Models\TblCableType;
use App\Models\TrnClientsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedCustomer = -1;
        $selectedCustomerCategory = -1;
        $selectedCustomerStatus = -1;
        $selectedPackage = -1;
        $selectedZone = -1;
        $selectedSubZone = -1;

        $menus = Menu::get();
        $customers = Customer::select(
            'customers.id as customer_id',
            'customers.customer_name',
            'customers.father_or_husband_name',
            'customers.mother_name',
            'customers.gender',
            'customers.blood_group',
            'customers.date_of_birth',
            'customers.reg_form_no',
            'customers.occupation',
            'customers.vat_status',
            'customers.nid_number',
            'customers.email',
            'customers.fb_id',
            'customers.mobile1',
            'customers.mobile2',
            'customers.phone',
            'customers.road_no',
            'customers.house_flat_no',
            'customers.area_id',
            'customers.district_id',
            'customers.upazila_id',
            'customers.tbl_zone_id',
            'customers.subzone_id',
            'customers.latitude',
            'customers.longitude',
            'customers.present_address',
            'customers.permanent_address',
            'customers.remarks',
            'customers.business_type_id',
            'customers.connection_employee_id',
            'customers.reference_by',
            'customers.contract_person',
            'customers.profile_pic',
            'customers.nid_pic',
            'customers.reg_form_pic',
            'customers.account_no',
            'customers.tbl_client_category_id',
            'customers.sub_office_id',

            'trn_clients_services.id as service_id',
            'trn_clients_services.srv_type_id',
            'trn_clients_services.user_id',
            'trn_clients_services.password',
            'trn_clients_services.bandwidth_plan_id',
            'trn_clients_services.installation_date',
            'trn_clients_services.remarks',
            'trn_clients_services.type_of_connectivity',
            'trn_clients_services.router_id',
            'trn_clients_services.device',
            'trn_clients_services.mac_address',
            'trn_clients_services.ip_number',
            'trn_clients_services.box_id',
            'trn_clients_services.cable_req',
            'trn_clients_services.no_of_core',
            'trn_clients_services.core_color',
            'trn_clients_services.fiber_code',
            'trn_clients_services.tbl_bill_type_id',
            'trn_clients_services.invoice_type_id',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.tbl_client_type_id',
            'trn_clients_services.monthly_bill',
            'trn_clients_services.billing_status_id',
            'trn_clients_services.tbl_status_type_id',
            'trn_clients_services.include_vat',
            'trn_clients_services.greeting_sms_sent',
            'tbl_client_types.name as package',
            'tbl_client_categories.name as client_type_name',
            'tbl_status_types.inv_name',
            'tbl_bill_types.bill_type_name'
        )
        ->leftJoin('trn_clients_services', 'customers.id', '=', 'trn_clients_services.customer_id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('tbl_client_categories', 'tbl_client_categories.id', '=', 'customers.tbl_client_category_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->where('trn_clients_services.srv_type_id', 1)
        ->get();
        // dd($customers); 

        $customers_dropdown = Customer::select('id as customer_id', 'customer_name')->orderBy('customer_name', 'desc')->get();
        $zones = TblZone::get();
        $subzones = SubZone::get();
        $areas = Area::get();
        $invoice_types = InvoiceType::select('id', 'invoice_type_name')->orderBy('invoice_type_name', 'desc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'desc')->get();
        $client_types = TblClientType::get();
        $bill_types = TblBillType::select('id', 'bill_type_name')->orderBy('bill_type_name', 'desc')->get();
        $districts = TblDistrict::get();
        $upazilas = Upazila::get();
        $routers = TblRouter::select('id', 'router_name')->orderBy('router_name', 'desc')->get();
        $business_types = BusinessType::get();
        $bandwidth_plans = TblBandwidthPlan::select('id','bandwidth_plan')->orderBy('id', 'desc')->get();
        $billing_statuses = BillingStatus::select('id', 'billing_status_name')->orderBy('billing_status_name', 'desc')->get();
        $boxes = Box::select('id', 'box_name')->orderBy('id', 'desc')->get();
        $employees = MasEmployee::get();
        $client_categories = TblClientCategory::select('id', 'name')->orderBy('name', 'desc')->get();
        $sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
        $cable_types = TblCableType::select('id', 'cable_type')->orderBy('id', 'desc')->get();
        return view(
            'pages.company.customers.customers_info',
            compact(
                'menus',
                'customers',
                'customers_dropdown',
                'zones',
                'subzones',
                'areas',
                'invoice_types',
                'status_types',
                'client_types',
                'bill_types',
                'districts',
                'upazilas',
                'routers',
                'business_types',
                'bandwidth_plans',
                'billing_statuses',
                'boxes',
                'employees',
                'client_categories',
                'sub_offices',
                'cable_types',
                'selectedCustomer',
                'selectedCustomerCategory',
                'selectedCustomerStatus',
                'selectedPackage',
                'selectedZone',
                'selectedSubZone'
            )
        );
    }
    public function search(Request $request)
    {
        // dd($request);
        $selectedCustomer = $request->customer;
        $selectedCustomerCategory = $request->customer_category;
        $selectedCustomerStatus = $request->customer_status;
        $selectedPackage = $request->package;
        $selectedZone = $request->zone;
        $selectedSubZone = $request->subzone;

        $menus = Menu::get();
        $customers = Customer::select(
            'customers.id as customer_id',
            'customers.customer_name',
            'customers.father_or_husband_name',
            'customers.mother_name',
            'customers.gender',
            'customers.blood_group',
            'customers.date_of_birth',
            'customers.reg_form_no',
            'customers.occupation',
            'customers.vat_status',
            'customers.nid_number',
            'customers.email',
            'customers.fb_id',
            'customers.mobile1',
            'customers.mobile2',
            'customers.phone',
            'customers.road_no',
            'customers.house_flat_no',
            'customers.area_id',
            'customers.district_id',
            'customers.upazila_id',
            'customers.tbl_zone_id',
            'customers.subzone_id',
            'customers.latitude',
            'customers.longitude',
            'customers.present_address',
            'customers.permanent_address',
            'customers.remarks',
            'customers.business_type_id',
            'customers.connection_employee_id',
            'customers.reference_by',
            'customers.contract_person',
            'customers.profile_pic',
            'customers.nid_pic',
            'customers.reg_form_pic',
            'customers.account_no',
            'customers.tbl_client_category_id',
            'customers.sub_office_id',

            'trn_clients_services.id as service_id',
            'trn_clients_services.srv_type_id',
            'trn_clients_services.user_id',
            'trn_clients_services.password',
            'trn_clients_services.bandwidth_plan_id',
            'trn_clients_services.installation_date',
            'trn_clients_services.remarks',
            'trn_clients_services.type_of_connectivity',
            'trn_clients_services.router_id',
            'trn_clients_services.device',
            'trn_clients_services.mac_address',
            'trn_clients_services.ip_number',
            'trn_clients_services.box_id',
            'trn_clients_services.cable_req',
            'trn_clients_services.no_of_core',
            'trn_clients_services.core_color',
            'trn_clients_services.fiber_code',
            'trn_clients_services.tbl_bill_type_id',
            'trn_clients_services.invoice_type_id',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.tbl_client_type_id',
            'trn_clients_services.monthly_bill',
            'trn_clients_services.billing_status_id',
            'trn_clients_services.tbl_status_type_id',
            'trn_clients_services.include_vat',
            'trn_clients_services.greeting_sms_sent',
            'tbl_client_types.name as package',
            'tbl_client_categories.name as client_type_name',
            'tbl_status_types.inv_name',
            'tbl_bill_types.bill_type_name'
        )
        ->leftJoin('trn_clients_services', 'customers.id', '=', 'trn_clients_services.customer_id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('tbl_client_categories', 'tbl_client_categories.id', '=', 'customers.tbl_client_category_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->where('trn_clients_services.srv_type_id', 1);
        if ($selectedCustomer>-1) {
            $customers->where('customer_id', $selectedCustomer);
        }
        if ($selectedCustomerCategory>-1) {
            $customers->where('tbl_client_categories.id', $selectedCustomerCategory);
        }
        if ($selectedCustomerStatus>-1) {
            $customers->where('tbl_status_types.id', $selectedCustomerStatus);
        }
        if ($selectedPackage>-1) {
            $customers->where('tbl_client_types.id', $selectedPackage);
        }
        if ($selectedZone>-1) {
            $customers->where('customers.tbl_zone_id', $selectedZone);
        }
        if ($selectedSubZone>-1) {
            $customers->where('customers.subzone_id', $selectedSubZone);
        }
        $customers = $customers->get();

        $customers_dropdown = Customer::select('id as customer_id', 'customer_name')->orderBy('customer_name', 'desc')->get();
        $zones = TblZone::get();
        $subzones = SubZone::get();
        $areas = Area::get();
        $invoice_types = InvoiceType::select('id', 'invoice_type_name')->orderBy('invoice_type_name', 'desc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'desc')->get();
        $client_types = TblClientType::get();
        $bill_types = TblBillType::select('id', 'bill_type_name')->orderBy('bill_type_name', 'desc')->get();
        $districts = TblDistrict::get();
        $upazilas = Upazila::get();
        $routers = TblRouter::select('id', 'router_name')->orderBy('router_name', 'desc')->get();
        $business_types = BusinessType::get();
        $bandwidth_plans = TblBandwidthPlan::select('id','bandwidth_plan')->orderBy('id', 'desc')->get();
        $billing_statuses = BillingStatus::select('id', 'billing_status_name')->orderBy('billing_status_name', 'desc')->get();
        $boxes = Box::select('id', 'box_name')->orderBy('id', 'desc')->get();
        $employees = MasEmployee::get();
        $client_categories = TblClientCategory::select('id', 'name')->orderBy('name', 'desc')->get();
        $sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
        $cable_types = TblCableType::select('id', 'cable_type')->orderBy('id', 'desc')->get();

        return view(
            'pages.company.customers.customers_info',
            compact(
                'menus',
                'customers',
                'customers_dropdown',
                'zones',
                'subzones',
                'areas',
                'invoice_types',
                'status_types',
                'client_types',
                'bill_types',
                'districts',
                'upazilas',
                'routers',
                'business_types',
                'bandwidth_plans',
                'billing_statuses',
                'boxes',
                'employees',
                'client_categories',
                'sub_offices',
                'cable_types',
                'selectedCustomer',
                'selectedCustomerCategory',
                'selectedCustomerStatus',
                'selectedPackage',
                'selectedZone',
                'selectedSubZone'
            )
        );
    }
    public function getUpazilaByDistrict($disctrictid)
    {
        $menus = Menu::get();
        $customers = Customer::with('InvoiceType', 'TblZone')->get();
        $districts = TblDistrict::get();
        $upazilas = Upazila::get();
        return view('customers.customers_info', compact('menus', 'customers'));
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
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        // dd($request);
        $prof_image = "";
        $nid_image = "";
        $regform_image = "";

        $request->validate([
            'customer_name' => 'required',
            'mobile1' => 'required|max:20',
        ]);

        if ($request->file('profile_pic') != '') {
            $file = $request->file('profile_pic')->getClientOriginalName();
            $prof_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $prof_image = $request->file('profile_pic')->move(public_path('/images/customers'), $prof_image);
        }

        if ($request->file('nid_pic') != '') {
            $file = $request->file('nid_pic')->getClientOriginalName();
            $nid_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $nid_image = $request->file('nid_pic')->move(public_path('/images/customers'), $nid_image);
        }

        if ($request->file('reg_form_pic') != '') {
            $file = $request->file('reg_form_pic')->getClientOriginalName();
            $regform_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $regform_image = $request->file('reg_form_pic')->move(public_path('/images/customers'), $regform_image);
        }

        $previous_account_no = Customer::max('account_no');
        $updated_account_no = $previous_account_no + 1;

        $request->validate([
            'customer_name' => 'required|unique:customers,customer_name',
        ]);

        $customer = Customer::create([
            "customer_name" => ($request->customer_name == null) ? '' : $request->customer_name,
            "father_or_husband_name" => ($request->father_or_husband_name == null) ? '' : $request->father_or_husband_name,
            "mother_name" => ($request->mother_name == null) ? '' : $request->mother_name,
            "gender" => ($request->gender == null) ? 0 : $request->gender,
            "blood_group" => ($request->blood_group == null) ? '' : $request->blood_group,
            "date_of_birth" => ($request->date_of_birth == null) ? '' : strtotime($request->date_of_birth),
            "reg_form_no" => ($request->reg_form_no == null) ? '' : $request->reg_form_no,
            "occupation" => ($request->occupation == null) ? '' : $request->occupation,
            "vat_status" => ($request->vat_status == null) ? '' : $request->vat_status,
            "nid_number" => ($request->nid_number == null) ? '' : $request->nid_number,
            "email" => ($request->email == null) ? '' : $request->email,
            "fb_id" => ($request->fb_id == null) ? '' : $request->fb_id,
            "mobile1" => ($request->mobile1 == null) ? '' : $request->mobile1,
            "mobile2" => ($request->mobile2 == null) ? '' : $request->mobile2,
            "phone" => ($request->phone == null) ? '' : $request->phone,
            "road_no" => ($request->road_no == null) ? '' : $request->road_no,
            "house_flat_no" => ($request->house_flat_no == null) ? '' : $request->house_flat_no,
            "area_id" => ($request->area_id == null) ? 0 : $request->area_id,
            "district_id" => ($request->district_id == null) ? 0 : $request->district_id,
            "upazila_id" => ($request->upazila_id == null) ? 0 : $request->upazila_id,
            "tbl_zone_id" => ($request->zone_id == null) ? 0 : $request->zone_id,
            "subzone_id" => ($request->subzone_id == null) ? 0 : $request->subzone_id,
            "latitude" => ($request->latitude == null) ? '' : $request->latitude,
            "longitude" => ($request->longitude == null) ? '' : $request->longitude,
            "present_address" => ($request->present_address == null) ? '' : $request->present_address,
            "permanent_address" => ($request->permanent_address == null) ? '' : $request->permanent_address,
            "remarks" => ($request->remarks == null) ? '' : $request->remarks,
            "business_type_id" => ($request->business_type_id == null) ? 0 : $request->business_type_id,
            "connection_employee_id" => ($request->connection_employee_id == null) ? 0 : $request->connection_employee_id,
            "reference_by" => ($request->reference_by == null) ? '' : $request->reference_by,
            "contract_person" => ($request->contract_person == null) ? '' : $request->contract_person,
            "profile_pic" => $prof_image,
            "nid_pic" => $nid_image,
            "reg_form_pic" => $regform_image,
            "account_no" => $updated_account_no,
            "tbl_client_category_id" => ($request->tbl_client_category_id == null) ? 0 : $request->tbl_client_category_id,
            "sub_office_id" => ($request->sub_office_id == null) ? 0 : $request->sub_office_id,
        ]);
     
            
        if($request->srv_type_id){
            TrnClientsService::create([
            "customer_id" => $customer->id,
            "srv_type_id" => 1,
            "link_from" =>  ($request->link_from == null) ? '' : $request->link_from,
            "link_to" =>  ($request->link_to == null) ? '' : $request->link_to,
            "bandwidth" =>  ($request->bandwidth == null) ? '' : $request->bandwidth,
            "unit_id" =>  ($request->unit_id == null) ? null : $request->unit_id,
            "unit_qty" =>  ($request->unit_qty == null) ? 0 : $request->unit_qty,
            "vat_rate" =>  ($request->vat_rate == null) ? 0 : $request->vat_rate,
            "rate_amnt" =>  ($request->rate_amnt == null) ? 0 : $request->rate_amnt,
            "vat_amnt" =>  ($request->vat_amnt == null) ? 0 : $request->vat_amnt,

            "user_id" => ($request->user_id == null) ? '' : $request->user_id,
            "password" => ($request->password == null) ? '' : $request->password,
            "bandwidth_plan_id" => ($request->bandwidth_plan_id == null) ? null : $request->bandwidth_plan_id,
            "installation_date" => ($request->installation_date == null) ? '' : $request->installation_date,
            "remarks" => ($request->remarks == null) ? '' : $request->remarks,
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
            "tbl_bill_type_id" => ($request->tbl_bill_type_id == null) ? 0 : $request->tbl_bill_type_id,
            "invoice_type_id" => 1,
            "bill_start_date" => ($request->bill_start_date == null) ? '' : $request->bill_start_date,
            "tbl_client_type_id" => ($request->tbl_client_type_id == null) ? null : $request->tbl_client_type_id,
            "monthly_bill" => ($request->monthly_bill == null) ? '' : $request->monthly_bill,
            "billing_status_id" => ($request->billing_status_id == null) ? null : $request->billing_status_id,
            "tbl_status_type_id" => ($request->tbl_status_type_id == null) ? 0 : $request->tbl_status_type_id,
            "include_vat" => ($request->include_vat == null) ? 0 : $request->include_vat,
            "greeting_sms_sent" => ($request->greeting_sms_sent == null) ? 0 : $request->greeting_sms_sent,

            "number_of_tv" => ($request->number_of_tv == null) ? 0 : $request->number_of_tv,
            "number_of_channel" => ($request->number_of_channel == null) ? 0 : $request->number_of_channel,
        ]);
        }

        return redirect('/customers')->with('success', 'Customer added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $customer)
    {
        $prof_image = "";
        $nid_image = "";
        $regform_image = "";

        $request->validate([
            'customer_name' => 'required',
            'mobile1' => 'required|max:20'
        ]);

        if ($request->file('profile_pic') != '') {
            $file = $request->file('profile_pic')->getClientOriginalName();
            $prof_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $prof_image = $request->file('profile_pic')->move(public_path('/images/customers'), $prof_image);
        }

        if ($request->file('nid_pic') != '') {
            $file = $request->file('nid_pic')->getClientOriginalName();
            $nid_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $nid_image = $request->file('nid_pic')->move(public_path('/images/customers'), $nid_image);
        }

        if ($request->file('reg_form_pic') != '') {
            $file = $request->file('reg_form_pic')->getClientOriginalName();
            $regform_image = pathinfo($file, PATHINFO_FILENAME) . "." . pathinfo($file, PATHINFO_EXTENSION);
            $regform_image = $request->file('reg_form_pic')->move(public_path('/images/customers'), $regform_image);
        }

        $customers = Customer::find($customer);
        $customers->customer_name = ($request->customer_name == null) ? '' : $request->customer_name;
        $customers->father_or_husband_name = ($request->father_or_husband_name == null) ? '' : $request->father_or_husband_name;
        $customers->mother_name = ($request->mother_name == null) ? '' : $request->mother_name;
        $customers->gender = ($request->gender == null) ? 0 : $request->gender;
        $customers->blood_group = ($request->blood_group == null) ? '' : $request->blood_group;
        $customers->date_of_birth = ($request->date_of_birth == null) ? '' : strtotime($request->date_of_birth);
        $customers->reg_form_no = ($request->reg_form_no == null) ? '' : $request->reg_form_no;
        $customers->occupation = ($request->occupation == null) ? '' : $request->occupation;
        $customers->vat_status = ($request->vat_status == null) ? '' : $request->vat_status;
        $customers->nid_number = ($request->nid_number == null) ? '' : $request->nid_number;
        $customers->email = ($request->email == null) ? '' : $request->email;
        $customers->fb_id = ($request->fb_id == null) ? '' : $request->fb_id;
        $customers->mobile1 = ($request->mobile1 == null) ? '' : $request->mobile1;
        $customers->mobile2 = ($request->mobile2 == null) ? '' : $request->mobile2;
        $customers->phone = ($request->phone == null) ? '' : $request->phone;
        $customers->road_no = ($request->road_no == null) ? '' : $request->road_no;
        $customers->house_flat_no = ($request->house_flat_no == null) ? '' : $request->house_flat_no;
        $customers->area_id = ($request->area_id == null) ? 0 : $request->area_id;
        $customers->district_id = ($request->district_id == null) ? 0 : $request->district_id;
        $customers->upazila_id = ($request->upazila_id == null) ? 0 : $request->upazila_id;
        $customers->tbl_zone_id = ($request->zone_id == null) ? 0 : $request->zone_id;
        $customers->subzone_id = ($request->subzone_id == null) ? 0 : $request->subzone_id;
        $customers->latitude = ($request->latitude == null) ? '' : $request->latitude;
        $customers->longitude = ($request->longitude == null) ? '' : $request->longitude;
        $customers->present_address = ($request->present_address == null) ? '' : $request->present_address;
        $customers->permanent_address = ($request->permanent_address == null) ? '' : $request->permanent_address;
        $customers->remarks = ($request->remarks == null) ? '' : $request->remarks;
        $customers->business_type_id = ($request->business_type_id == null) ? 0 : $request->business_type_id;
        $customers->connection_employee_id = ($request->connection_employee_id == null) ? 0 : $request->connection_employee_id;
        $customers->reference_by = ($request->reference_by == null) ? '' : $request->reference_by;
        $customers->contract_person = ($request->contract_person == null) ? '' : $request->contract_person;
        $customers->profile_pic = $prof_image;
        $customers->nid_pic = $nid_image;
        $customers->reg_form_pic = $regform_image;
        $customers->tbl_client_category_id = ($request->tbl_client_category_id == null) ? 0 : $request->tbl_client_category_id;
        $customers->sub_office_id = ($request->sub_office_id == null) ? 0 : $request->sub_office_id;
        $customers->save();

        return redirect('/customers')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
