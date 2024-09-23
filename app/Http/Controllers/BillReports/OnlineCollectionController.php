<?php

namespace App\Http\Controllers\BillReports;

use App\Http\Controllers\Controller;
use App\Models\AdvanceBill;
use App\Models\BillType;
use App\Models\Customer;
use App\Models\User;
use App\Models\MasInvoice;
use App\Models\Menu;
use App\Models\TrnClientsService;
use App\Models\TblSrvType;
use App\Models\MasBank;
use App\Models\NislMasMember;
use App\Models\SubZone;
use App\Models\TblClientCategory;
use App\Models\TblClientType;
use App\Models\TblZone;
use App\Models\TblSuboffice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\pick;
use function App\Helpers\dateDifference;

use App\Models\TblStatusType;
use App\Models\TblBillType;
use App\Models\TblBandwidthPlan;
use App\Models\MasCollection;



class OnlineCollectionController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedZone = -1;
        $selectedPackage = -1;
        $selectedCustomerStatus = -1;
        $selectedCurrentStatus = -1;
        $selectedCustomer = -1;
		$selectedBranch = -1;
		$nowdate = Carbon::now()->format('Y-m-d');
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		
		$subzone =  -1;
		$selectedcategory = -1;
		
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

 $cust_invoices = MasCollection::query()
						->Join('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'mas_collections.customer_id')
         ->select([
						'mas_collections.adv_rec',
						  'money_receipt',	
						  DB::raw('DATE_FORMAT(mas_collections.collection_date, "%m/%d/%Y") AS advrec_date'),
						  'mas_collections.coll_amount',
						  'customers.customer_name',
						  'trn_clients_services.user_id',
        ])
		 ->where('mas_collections.pay_type','D')
		 ->where(DB::raw("DATE_FORMAT(mas_collections.collection_date,'%Y-%m-%d')"),'>=', $start_date)
		 ->where(DB::raw("DATE_FORMAT(mas_collections.collection_date,'%Y-%m-%d')"),'<=', $end_date);
		
 
        if ($selectedZone>-1) {
            $cust_invoices->where('customers.tbl_zone_id', $selectedZone);
        }
		if ($selectedcategory>-1) {
            $cust_invoices->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($subzone>-1) {
            $cust_invoices->where('customers.sub_office_id', $subzone);
        }
		
        $cust_invoices = $cust_invoices->get();

        return view("pages.billing.reports.onlineCollection", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","selectedBranch","selectedcategory","nowdate","start_date","end_date"));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $selectedZone = $request->zone;
        $selectedPackage = $request->package;
        $selectedCustomerStatus = $request->customer_status;
        $selectedCurrentStatus = $request->current_status;
        $selectedCustomer = $request->customer;
		$nowdate = Carbon::now()->format('Y-m-d');

		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
	 
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

        $cust_invoices = MasCollection::query()
						->Join('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'mas_collections.customer_id')
        ->select([
						'mas_collections.adv_rec',
						  'money_receipt',	
						  DB::raw('DATE_FORMAT(mas_collections.collection_date, "%m/%d/%Y") AS advrec_date'),
						  'mas_collections.coll_amount',
						  'customers.customer_name',
						  'trn_clients_services.user_id',
        ])
		 ->where('mas_collections.pay_type','D')
		 ->where(DB::raw("DATE_FORMAT(mas_collections.collection_date,'%Y-%m-%d')"),'>=', $start_date)
		 ->where(DB::raw("DATE_FORMAT(mas_collections.collection_date,'%Y-%m-%d')"),'<=', $end_date);

        if ($selectedZone>-1) {
            $cust_invoices->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $cust_invoices->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $cust_invoices->where('customers.sub_office_id', $selectedBranch);
        }
		
        $cust_invoices = $cust_invoices->get();

        return view("pages.billing.reports.onlineCollection", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","selectedBranch","selectedcategory","nowdate","start_date","end_date"));
    }

    
	/**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}