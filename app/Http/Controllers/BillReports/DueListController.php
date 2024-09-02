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



class DueListController extends Controller
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

 $due_lists = MasInvoice::query()
						->Join('customers', 'customers.id', '=', 'mas_invoices.customer_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						->Join('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->Join('invoice_types', 'invoice_types.id', '=', 'mas_invoices.tbl_invoice_cat_id')
						
        ->select([
						'customers.customer_name',
						'customers.id as customers_id',
						'trn_clients_services.tbl_status_type_id',
						'tbl_status_types.inv_name',
						'invoice_number',
						'bill_number',
						DB::raw("DATE_FORMAT(invoice_date,'%d/%m/%Y') as invoicedate"),
						DB::raw("MONTH(invoice_date) as imonth"),
						DB::raw("YEAR(invoice_date) as iyear"),
						'invoice_date',
						'invoice_types.invoice_type_name',
						'vatper',
						'mas_invoices.vat',
						'mas_invoices.bill_amount',
						'mas_invoices.ip_number',
						'mas_invoices.id as invoiceobjet_id',
						'total_bill',
						'collection_amnt',
						'ait_adjustment',
						'vat_adjust_ment',
						'downtimeadjust',
						'discount_amnt',
						DB::raw("(total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment-other_adjustment-downtimeadjust) as due"),
        ])
		 ->where(DB::raw('total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment'),'>' ,0)
		 ->where(DB::raw('total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment-other_adjustment-downtimeadjust'),'>' ,0)
		->orderBy('customers_id')
		->orderBy('invoice_date')
		->orderBy('invoice_number');
 
        if ($selectedZone>-1) {
            $due_lists->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $due_lists->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $due_lists->where('customers.sub_office_id', $selectedBranch);
        }
		
        $due_lists = $due_lists->get();

        return view("pages.billing.reports.dueList", compact("menus", "zones", "client_category", "status_types", "customers", "due_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_month","start_year","selectedBranch","selectedcategory"));
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
		
		$start_month = $request->month;
		$start_year = $request->year;
		$selectedDate=$start_year.'-'.$start_month.'-1'; 
		
		
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

        $due_lists = MasInvoice::query()
						->Join('customers', 'customers.id', '=', 'mas_invoices.customer_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						->Join('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
						->Join('invoice_types', 'invoice_types.id', '=', 'mas_invoices.tbl_invoice_cat_id')
						
        ->select([
						'customers.customer_name',
						'customers.id as customers_id',
						'trn_clients_services.tbl_status_type_id',
						'tbl_status_types.inv_name',
						'invoice_number',
						'bill_number',
						DB::raw("DATE_FORMAT(invoice_date,'%d/%m/%Y') as invoicedate"),
						DB::raw("MONTH(invoice_date) as imonth"),
						DB::raw("YEAR(invoice_date) as iyear"),
						'invoice_date',
						'invoice_types.invoice_type_name',
						'vatper',
						'mas_invoices.vat',
						'mas_invoices.bill_amount',
						'mas_invoices.ip_number',
						'mas_invoices.id as invoiceobjet_id',
						'total_bill',
						'collection_amnt',
						'ait_adjustment',
						'vat_adjust_ment',
						'downtimeadjust',
						'discount_amnt',
						DB::raw("(total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment-other_adjustment-downtimeadjust) as due"),
        ])
		 ->where(DB::raw('total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment'),'>' ,0)
		 ->where(DB::raw('total_bill-collection_amnt-ait_adjustment-discount_amnt-vat_adjust_ment-other_adjustment-downtimeadjust'),'>' ,0)
		->orderBy('customers_id')
		->orderBy('invoice_date')
		->orderBy('invoice_number');
		    
	if ($start_month >= 1) {
			$due_lists->where('invoice_date','<=' ,$last);
		}

        if ($selectedZone>-1) {
            $due_lists->where('customers.tbl_zone_id', $selectedZone);
        }
		
		if ($selectedcategory>-1) {
            $due_lists->where('customers.tbl_client_category_id', $selectedcategory);
        }
		
		if ($selectedBranch>-1) {
            $due_lists->where('customers.sub_office_id', $selectedBranch);
        }
		
        $due_lists = $due_lists->get();

        return view("pages.billing.reports.dueList", compact("menus", "zones", "client_category", "status_types", "customers", "due_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_month","start_year","selectedBranch","selectedcategory"));
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