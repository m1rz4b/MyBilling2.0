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



class DailyBillCollectionController extends Controller
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
	
		$start_day = date("d");
		$start_month = date("m");
		$start_year = date("Y");
		
		$start_date = date("Y-m-d");
		$last = date('Y-m-t', strtotime($start_date));
		$fast=date('Y-m-01', strtotime($start_date));
		$subzone =  -1;
		$selectedcategory = -1;
		

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

 $cust_invoices = MasCollection::query()
						->Join('customers', 'customers.id', '=', 'mas_collections.customer_id')
        ->select([
					'mas_collections.id', 
					'mas_collections.customer_id', 
					'customers.customer_name',
					'mas_collections.money_receipt', 
					'mas_collections.collection_date', 
					DB::raw("(SELECT Sum(a.collamnt)
					FROM trn_collections as a
					INNER JOIN  mas_collections as b ON b.id = a.id
					INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
					WHERE (c.invoice_date<'".$fast."') AND a.id=mas_collections.id) as ccollamnt"),
					DB::raw("(SELECT Sum(a.collamnt)
					FROM trn_collections as a
					INNER JOIN  mas_collections as b ON b.id = a.id
					INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
					WHERE (c.invoice_date>='".$fast."' AND c.invoice_date<='".$last."') AND a.id=mas_collections.id) as qcollamnt"),
					DB::raw("(SELECT d.coll_amount FROM mas_collections as d WHERE  d.adv_stat=1 and d.id=mas_collections.id) as ad,
					mas_collections.adv_rec as adnormal"),
        ])
        ->where('mas_collections.collection_date', $start_date);
		
 
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

        return view("pages.billing.reports.dailyBillCollection", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_day","start_month","start_year","selectedBranch","selectedcategory"));
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
		
		$start_day = $request->day;
		$start_month = $request->month;
		$start_year = $request->year;
		$selectedDate=$start_year.'-'.$start_month.'-'.$start_day; 
		
		
	//	$start_date = date("Y-m-d");
        $last = date('Y-m-t', strtotime($selectedDate));
		$fast=date('Y-m-01', strtotime($selectedDate));
		 
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

        $cust_invoices = MasCollection::query()
						->Join('customers', 'customers.id', '=', 'mas_collections.customer_id')
        ->select([
					'mas_collections.id', 
					'mas_collections.customer_id', 
					'customers.customer_name',
					'mas_collections.money_receipt', 
					'mas_collections.collection_date', 
					DB::raw("(SELECT Sum(a.collamnt)
					FROM trn_collections as a
					INNER JOIN  mas_collections as b ON b.id = a.collection_id
					INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
					WHERE (c.invoice_date<'".$fast."') AND a.id=mas_collections.id) as ccollamnt"),
					DB::raw("(SELECT Sum(a.collamnt)
					FROM trn_collections as a
					INNER JOIN  mas_collections as b ON b.id = a.collection_id
					INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
					WHERE (c.invoice_date>='".$fast."' AND c.invoice_date<='".$last."') AND a.collection_id=mas_collections.id) as qcollamnt"),
					DB::raw("(SELECT d.coll_amount FROM mas_collections as d WHERE  d.adv_stat=1 and d.id=mas_collections.id) as ad,
					mas_collections.adv_rec as adnormal"),
        ])
        ->where('mas_collections.collection_date', $selectedDate);
 
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

        return view("pages.billing.reports.dailyBillCollection", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches" ,"start_day","start_month","start_year","selectedBranch","selectedcategory"));
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