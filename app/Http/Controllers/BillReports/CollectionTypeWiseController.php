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



class CollectionTypeWiseController extends Controller
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
	
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		
	//	$start_month = date("m");
	//	$start_year = date("Y");
		
	//	$start_date = date("Y-m-d");
	//	$last = date('Y-m-t', strtotime($start_date));
	//	$fast=date('Y-m-01', strtotime($start_date));
		$subzone =  -1;
		$selectedcategory = -1;
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

 $collection_lists = MasCollection::query()
						->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->leftJoin('mas_banks', 'mas_banks.id', '=', 'mas_collections.bank_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						
        ->select([		
						DB::raw("if(mas_collections.pay_type='C',mas_collections.coll_amount,0) as  ccollamnt"),
						DB::raw("if(mas_collections.pay_type='Q',mas_collections.coll_amount,0) as  qcollamnt"),
						DB::raw("if(mas_collections.pay_type='D',mas_collections.coll_amount,0) as  dcollamnt"),
						DB::raw("DATE_FORMAT(mas_collections.collection_date,'%d/%m/%Y') as collection_date"),
						'mas_collections.coll_amount as collamnt',
						'customers.customer_name',
						'customers.id as customers_id',
						'trn_clients_services.user_id',
						'mas_collections.money_receipt',
						'mas_collections.cheque_no',
						'mas_banks.bank_name',
						'mas_collections.pay_type',
						DB::raw("DATE_FORMAT(mas_collections.cheque_date,'%d/%m/%Y') as cheque_date"),				
        ])
		->orderBy('collection_date' , 'desc')
		->orderBy('customers_id');
 
 		$collection_lists->where('collection_date','>=' ,$start_date);
		$collection_lists->where('collection_date','<=' ,$end_date);
		
        if ($selectedZone>-1) {
            $collection_lists->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $collection_lists->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $collection_lists->where('customers.sub_office_id', $selectedBranch);
        }
		
        $collection_lists = $collection_lists->get();

        return view("pages.billing.reports.collectionTypeWise", compact("menus", "zones", "client_category", "status_types", "customers", "collection_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","end_date","selectedBranch","selectedcategory"));
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
		
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
		
	//	$start_month = $request->month;
	//	$start_year = $request->year;
	//	$selectedDate=$start_year.'-'.$start_month.'-1'; 
		
		
	////	$start_date = date("Y-m-d");
    //    $last = date('Y-m-t', strtotime($selectedDate));
	//	$fast=date('Y-m-01', strtotime($selectedDate));
		 
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

         $collection_lists = MasCollection::query()
						->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->leftJoin('mas_banks', 'mas_banks.id', '=', 'mas_collections.bank_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						
        ->select([		
						DB::raw("if(mas_collections.pay_type='C',mas_collections.coll_amount,0) as  ccollamnt"),
						DB::raw("if(mas_collections.pay_type='Q',mas_collections.coll_amount,0) as  qcollamnt"),
						DB::raw("if(mas_collections.pay_type='D',mas_collections.coll_amount,0) as  dcollamnt"),
						DB::raw("DATE_FORMAT(mas_collections.collection_date,'%d/%m/%Y') as collection_date"),
						'mas_collections.coll_amount as collamnt',
						'customers.customer_name',
						'customers.id as customers_id',
						'trn_clients_services.user_id',
						'mas_collections.money_receipt',
						'mas_collections.cheque_no',
						'mas_banks.bank_name',
						'mas_collections.pay_type',
						DB::raw("DATE_FORMAT(mas_collections.cheque_date,'%d/%m/%Y') as cheque_date"),				
        ])
		->orderBy('collection_date' , 'desc')
		->orderBy('customers_id');
 
 		$collection_lists->where('collection_date','>=' ,$start_date);
		$collection_lists->where('collection_date','<=' ,$end_date);
		
        if ($selectedZone>-1) {
            $collection_lists->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $collection_lists->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $collection_lists->where('customers.sub_office_id', $selectedBranch);
        }
		
        $collection_lists = $collection_lists->get();

        return view("pages.billing.reports.collectionTypeWise", compact("menus", "zones", "client_category", "status_types", "customers", "collection_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","end_date","selectedBranch","selectedcategory"));
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