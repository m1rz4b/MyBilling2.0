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



class CollectionSummeryController extends Controller
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
		$invoiceMonth = date("m");
        $invoiceYear = date("Y");
		$subzone =  -1;
		$selectedcategory = -1;
		

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

		$selectedDate=$invoiceYear.'-'.$invoiceMonth.'-1'; 
        $last = date('Y-m-t', strtotime($selectedDate));
		$fast=date('Y-m-01', strtotime($selectedDate));
		
		$ccond="";
		 if ($selectedZone>-1) {
		 $ccond.=" AND (customers.tbl_zone_id='".$selectedZone."')";
		 }
				
		if ($selectedcategory>-1) {
		 $ccond.=" AND customers.client_catagory='".$selectedcategory."'";
		 }

		if ($selectedBranch>-1) {
		$ccond.=" And customers.subzone_id = '".$selectedBranch."'";
		 }
		 
        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

        $cust_invoices = MasCollection::query()
			->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
					
			->select([
				DB::raw('DATE_FORMAT(mas_collections.collection_date, "%d/%m/%Y") AS collection_date'),
				'mas_collections.collection_date as cdate', 
				DB::raw('MONTH(mas_collections.collection_date) AS cmonth'),
				DB::raw('YEAR(mas_collections.collection_date) as cyear'),
				DB::raw("(
				SELECT Sum(a.collamnt)
				FROM trn_collections as a
				INNER JOIN  mas_collections as b ON b.id = a.collection_id
				INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
				LEFT JOIN customers ON customers.id=a.client_Id  
				WHERE (c.invoice_date<'".$fast."') and b.collection_date=mas_collections.collection_date  $ccond) as tcc") ,    
				DB::raw("(SELECT Sum(a.collamnt)
				FROM trn_collections as a
				INNER JOIN  mas_collections as b ON b.id = a.collection_id
				INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
				LEFT JOIN customers ON customers.id=a.client_Id  
				WHERE (c.invoice_date>='".$fast."' AND c.invoice_date<='".$last."') and b.collection_date=mas_collections.collection_date $ccond) as tcq,
				sum(mas_collections.adv_rec) as adnormal"),
				DB::raw("(SELECT Sum(d.coll_amount) 
				 FROM mas_collections as d 
				 LEFT JOIN customers ON customers.id=d.customer_id 
				 WHERE  d.adv_stat=1 and d.collection_date=mas_collections.collection_date $ccond) as ad"),
        ])
        ->where('mas_collections.collection_date', '>=' ,$fast)
		->where('mas_collections.collection_date', '<=' ,$last)
		->groupBy('mas_collections.collection_date');
	
        $cust_invoices = $cust_invoices->get();

        return view("pages.billing.reports.collectionSummery", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth", "invoiceYear","selectedBranch" , "selectedcategory"));
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
		$invoiceMonth = $request->month;
        $invoiceYear = $request->year;
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;
		
		$selectedDate=$invoiceYear.'-'.$invoiceMonth.'-1'; 
        $last = date('Y-m-t', strtotime($selectedDate));
		$fast=date('Y-m-01', strtotime($selectedDate));
		$ccond="";
		 if ($selectedZone>-1) {
		 $ccond.=" AND (customers.tbl_zone_id='".$selectedZone."')";
		 }
				
		if ($selectedcategory>-1) {
		 $ccond.=" AND customers.client_catagory='".$selectedcategory."'";
		 }

		if ($selectedBranch>-1) {
		$ccond.=" And customers.subzone_id = '".$selectedBranch."'";
		 }
		 
        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

        $cust_invoices = MasCollection::query()
			->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
					
			->select([
				DB::raw('DATE_FORMAT(mas_collections.collection_date, "%d/%m/%Y") AS collection_date'),
				'mas_collections.collection_date as cdate', 
				DB::raw('MONTH(mas_collections.collection_date) AS cmonth'),
				DB::raw('YEAR(mas_collections.collection_date) as cyear'),
				DB::raw("(
				SELECT Sum(a.collamnt)
				FROM trn_collections as a
				INNER JOIN  mas_collections as b ON b.id = a.collection_id
				INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
				LEFT JOIN customers ON customers.id=a.client_Id  
				WHERE (c.invoice_date<'".$fast."') and b.collection_date=mas_collections.collection_date  $ccond) as tcc") ,    
				DB::raw("(SELECT Sum(a.collamnt)
				FROM trn_collections as a
				INNER JOIN  mas_collections as b ON b.id = a.collection_id
				INNER JOIN mas_invoices as c ON a.masinvoiceobject_id = c.id
				LEFT JOIN customers ON customers.id=a.client_Id  
				WHERE (c.invoice_date>='".$fast."' AND c.invoice_date<='".$last."') and b.collection_date=mas_collections.collection_date $ccond) as tcq,
				sum(mas_collections.adv_rec) as adnormal"),
				DB::raw("(SELECT Sum(d.coll_amount) 
				 FROM mas_collections as d 
				 LEFT JOIN customers ON customers.id=d.customer_id 
				 WHERE  d.adv_stat=1 and d.collection_date=mas_collections.collection_date $ccond) as ad"),
        ])
        ->where('mas_collections.collection_date', '>=' ,$fast)
		->where('mas_collections.collection_date', '<=' ,$last)
		->groupBy('mas_collections.collection_date');
		
        $cust_invoices = $cust_invoices->get();

        return view("pages.billing.reports.collectionSummery", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches" ,"invoiceMonth", "invoiceYear","selectedBranch", "selectedcategory"));
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