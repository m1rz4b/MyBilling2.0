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
use App\Models\ChangeClientStatus;



class ClientExpiryController extends Controller
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
	
//		$start_day = date("d");
//		$start_month = date("m");
//		$start_year = date("Y");
		
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");

//		$last = date('Y-m-t', strtotime($start_date));
//		$fast=date('Y-m-01', strtotime($start_date));
		$subzone =  -1;
		$selectedcategory = -1;
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();

		
/////////////Block Client//////////
$block_list = TrnClientsService::query()
						->leftJoin('customers', 'customers.id', '=', 'trn_clients_services.customer_id')
						->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
						->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->leftJoin('tbl_zone', 'tbl_zone.id', '=', 'customers.tbl_zone_id')	
						->leftJoin('radcheck', 'radcheck.username', '=', 'trn_clients_services.user_id')	
						
        ->select([							
						'customers.id',
						'customers.customer_name',
						'customers.contract_person',
						'tbl_client_types.name AS package', 
						'trn_clients_services.ip_number',
						'customers.mobile1',
						'customers.account_no',
						'customers.present_address',
						'trn_clients_services.user_id',		
						DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS inst_date'),
						DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS start_date'),
						'tbl_status_types.inv_name',
						DB::raw('DATE_FORMAT(trn_clients_services.block_date, "%d/%m/%Y") AS block_date'),
						'trn_clients_services.rate_amnt',
						'tbl_zone.zone_name',
						'radcheck.value',						
        ])

		->orderBy('customers.id')->distinct();
		$block_list->where('trn_clients_services.block_date','>=' ,$start_date);
		$block_list->where('trn_clients_services.block_date','<=' ,$end_date);
		$block_list->where('trn_clients_services.tbl_status_type_id',1);
		$block_list->where('radcheck.attribute','Expiration');
		   
        if ($selectedZone>-1) {
            $block_list->where('customers.tbl_zone_id', $selectedZone);
        }
		if ($selectedcategory>-1) {
            $block_list->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $block_list->where('customers.sub_office_id', $selectedBranch);
        }
		
		if ($selectedPackage>-1) {
            $block_list->where('trn_clients_services.tbl_client_type_id', $selectedPackage);
        }
		
		if ($selectedCustomerStatus>-1) {
            $block_list->where('trn_clients_services.tbl_status_type_id', $selectedCustomerStatus);
        }
		
        $block_list = $block_list->get();
///////////////////////////

        return view("pages.billing.reports.clientExpiry", compact("menus", "zones", "client_category", "status_types", "customers", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","selectedBranch","selectedcategory","clienttypes",'block_list','end_date'));
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
		
//		$start_day = $request->day;
//		$start_month = $request->month;
//		$start_year = $request->year;
//		$selectedDate=$start_year.'-'.$start_month.'-'.$start_day; 
		
		
	//	$start_date = date("Y-m-d");
  //      $last = date('Y-m-t', strtotime($selectedDate));
//		$fast=date('Y-m-01', strtotime($selectedDate));
		 
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();

/////////////Block Client//////////
$block_list = TrnClientsService::query()
						->leftJoin('customers', 'customers.id', '=', 'trn_clients_services.customer_id')
						->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
						->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->leftJoin('tbl_zone', 'tbl_zone.id', '=', 'customers.tbl_zone_id')	
						->leftJoin('radcheck', 'radcheck.username', '=', 'trn_clients_services.user_id')
        ->select([							
						'customers.id',
						'customers.customer_name',
						'customers.contract_person',
						'tbl_client_types.name AS package', 
						'trn_clients_services.ip_number',
						'customers.mobile1',
						'customers.account_no',
						'customers.present_address',
						'trn_clients_services.user_id',		
						DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS inst_date'),
						DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS start_date'),
						'tbl_status_types.inv_name',
						DB::raw('DATE_FORMAT(trn_clients_services.block_date, "%d/%m/%Y") AS block_date'),
						'trn_clients_services.rate_amnt',
						'tbl_zone.zone_name',
						'radcheck.value',						
        ])

		->orderBy('customers.id')->distinct();
		$block_list->where('trn_clients_services.block_date','>=' ,$start_date);
		$block_list->where('trn_clients_services.block_date','<=' ,$end_date);
		$block_list->where('trn_clients_services.tbl_status_type_id',1);
		$block_list->where('radcheck.attribute','Expiration');
		   
        if ($selectedZone>-1) {
            $block_list->where('customers.tbl_zone_id', $selectedZone);
        }
		if ($selectedcategory>-1) {
            $block_list->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $block_list->where('customers.sub_office_id', $selectedBranch);
        }
		
		if ($selectedPackage>-1) {
            $block_list->where('trn_clients_services.tbl_client_type_id', $selectedPackage);
        }
		
		if ($selectedCustomerStatus>-1) {
            $block_list->where('trn_clients_services.tbl_status_type_id', $selectedCustomerStatus);
        }
		
        $block_list = $block_list->get();
///////////////////////////
        return view("pages.billing.reports.clientExpiry", compact("menus", "zones", "client_category", "status_types", "customers", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","selectedBranch","selectedcategory","clienttypes",'block_list','end_date'));
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