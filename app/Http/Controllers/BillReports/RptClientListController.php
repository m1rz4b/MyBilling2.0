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



class RptClientListController extends Controller
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
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();

 $client_list = Customer::query()
						->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
						->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->leftJoin('mas_invoices', 'mas_invoices.customer_id', '=', 'customers.id')
        ->select([
					'customers.id',
                    'customers.customer_name',
					'trn_clients_services.user_id',
                    'customers.present_address',
                    'customers.email',
					"tbl_client_types.price as rate_amnt",
                    'trn_clients_services.vat_amnt',
                    'customers.account_no',
                  	'customers.contract_person',
                    'tbl_client_types.name AS clienttype', 
					DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS inst_date'),
					DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS start_date'),
					DB::raw('(SELECT sum(cur.total_bill) FROM mas_invoices as cur WHERE cur.customer_id = mas_invoices.customer_id  group by cur.customer_id) as cur_total'),
					DB::raw('(SELECT sum(cur.collection_amnt) FROM mas_invoices as cur WHERE cur.customer_id = mas_invoices.customer_id  group by cur.customer_id) as cur_collection'),
                    'trn_clients_services.ip_number',
					'tbl_status_types.inv_name',
					
        ])

		->orderBy('customers.id')->distinct();
  //      ->where('mas_collections.collection_date', $start_date);
		
 	//$cond
			//		order by user_id
        if ($selectedZone>-1) {
            $client_list->where('customers.tbl_zone_id', $selectedZone);
        }
		if ($selectedcategory>-1) {
            $client_list->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($subzone>-1) {
            $client_list->where('customers.sub_office_id', $subzone);
        }
		
		if ($selectedPackage>-1) {
            $client_list->where('trn_clients_services.tbl_client_type_id', $selectedPackage);
        }
		
		if ($selectedCustomerStatus>-1) {
            $client_list->where('trn_clients_services.tbl_status_type_id', $selectedCustomerStatus);
        }
		
        $client_list = $client_list->get();

        return view("pages.billing.reports.rptClientList", compact("menus", "zones", "client_category", "status_types", "customers", "client_list", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_day","start_month","start_year","selectedBranch","selectedcategory","clienttypes"));
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

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();

        $client_list = Customer::query()
						->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
						->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->leftJoin('mas_invoices', 'mas_invoices.customer_id', '=', 'customers.id')
        ->select([
					'customers.id',
                    'customers.customer_name',
					'trn_clients_services.user_id',
                    'customers.present_address',
                    'customers.email',
					"tbl_client_types.price as rate_amnt",
                    'trn_clients_services.vat_amnt',
                    'customers.account_no',
                  	'customers.contract_person',
                    'tbl_client_types.name AS clienttype', 
					DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS inst_date'),
					DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS start_date'),
					DB::raw('(SELECT sum(cur.total_bill) FROM mas_invoices as cur WHERE cur.customer_id = mas_invoices.customer_id  group by cur.customer_id) as cur_total'),
					DB::raw('(SELECT sum(cur.collection_amnt) FROM mas_invoices as cur WHERE cur.customer_id = mas_invoices.customer_id  group by cur.customer_id) as cur_collection'),
                    'trn_clients_services.ip_number',
					'tbl_status_types.inv_name',
					
        ])

		->orderBy('customers.id')->distinct();
 //       ->where('mas_collections.collection_date', $selectedDate);
 
        if ($selectedZone>-1) {
            $client_list->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $client_list->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $client_list->where('customers.sub_office_id', $selectedBranch);
        }
		
		if ($selectedPackage>-1) {
            $client_list->where('trn_clients_services.tbl_client_type_id', $selectedPackage);
        }
		
		if ($selectedCustomerStatus>-1) {
            $client_list->where('trn_clients_services.tbl_status_type_id', $selectedCustomerStatus);
        }
		
        $client_list = $client_list->get();

        return view("pages.billing.reports.rptClientList", compact("menus", "zones", "client_category", "status_types", "customers", "client_list", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches" ,"start_day","start_month","start_year","selectedBranch","selectedcategory","clienttypes"));
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