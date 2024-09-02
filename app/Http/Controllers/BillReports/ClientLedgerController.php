<?php

//namespace App\Http\Controllers;
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



class ClientLedgerController extends Controller
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
		$invoiceMonth = date("m");
        $invoiceYear = date("Y");
		$invoiceTmonth = date("m");
        $invoiceTyear = date("Y");
		$subzone =  -1;
		$customer = -1;
		
		 $Fdate = "2000-01-01"; 
		 $tdate = "2000-01-01";
		

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_types = TblClientType::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		
		$cust_invoices = DB::select('SELECT
							 invoice_number as invoice_number,
							  DATE_FORMAT(invoice_date,"%d-%m-%Y") as invoice_date,
							  "" as collection_date,
							  invoice_date as orderdate,
							  total_bill as total,
							  "0" as ctotal,
							  other_adjustment as other_adjustment,
							  discount_amnt as discoun_amnt,
							  ait_adjustment as ait_adjustment,
							  vat_adjust_ment as vat_adjust_ment,
							  downtimeadjust as downtimeadjust,
							  "IN" as type,
							  invoice_types.invoice_type_name as invtype,
							  tbl_client_types.name as package,
							  MONTH(invoice_date) as month,
							  YEAR(invoice_date) as year,
							  "" as money_receipt,
							  "" as collection_remarks
							FROM
							  mas_invoices
							LEFT JOIN tbl_client_types ON tbl_client_types.id=mas_invoices.client_type
							LEFT JOIN invoice_types ON invoice_types.id=mas_invoices.tbl_invoice_cat_id							
							WHERE
							  mas_invoices.customer_id="'.$customer.'" AND invoice_date>="'.$Fdate.'"  AND invoice_date<="'.$tdate.'"
							UNION
							SELECT
								"" as invoice_number,
								"" as invoice_date,
								DATE_FORMAT(collection_date,"%d-%m-%Y") as collection_date,
								collection_date as orderdate,
								"0" as total,
								coll_amount as ctotal,
								"0" as other_adjustment,
								discoun_amnt as discoun_amnt,
								aitadjust as ait_adjustment,
							    vatadjust as vat_adjust_ment,
								downtimeadjust as downtimeadjust,
								"CO" as type,
								"Collection" as invtype,
								"" as package,
								"" as month,
								"" as year,
								money_receipt as money_receipt,
								mas_collections.remarks as collection_remarks
							FROM
								mas_collections									
							WHERE    
							   mas_collections.customer_id="'.$customer.'"	AND collection_date>="'.$Fdate.'" AND collection_date<="'.$tdate.'"   
							 ORDER BY orderdate ASC');



        return view("pages.billing.reports.clientLedger", compact("menus", "zones", "client_types", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth", "invoiceYear", "invoiceTmonth", "invoiceTyear"));
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
		$invoiceTmonth = $request->tmonth;
        $invoiceTyear = $request->tyear;
		$subzone = $request->branch;
		$customer = $request->customer;
		
		 $Fdate = "$invoiceYear-$invoiceMonth-01"; 
		 $tdate = "$invoiceTyear-$invoiceTmonth-01"; 
		 
		
//		 $d = new DateTime("$invoiceYear-$invoiceTmonth-01"); 
//		$tdate = $d->format('Y-m-t');

		 $tdate=date_create($tdate);
	//	$tdate=date_format($tdate,"Y-m-t");

	//	$Fdate = "2024-01-01"; 
	//	$tdate = "2024-08-31";
	//	$tdate=date_create($tdate);
		$tdate=date_format($tdate,"Y-m-t");
		      
        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_types = TblClientType::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		
		
						$cust_invoices = DB::select('SELECT
							invoice_number as invoice_number,
							  DATE_FORMAT(invoice_date,"%d-%m-%Y") as invoice_date,
							  "" as collection_date,
							  invoice_date as orderdate,
							  total_bill as total,
							  "0" as ctotal,
							  other_adjustment as other_adjustment,
							  discount_amnt as discoun_amnt,
							  ait_adjustment as ait_adjustment,
							  vat_adjust_ment as vat_adjust_ment,
							  downtimeadjust as downtimeadjust,
							  "IN" as type,
							  invoice_types.invoice_type_name as invtype,
							  tbl_client_types.name as package,
							  MONTH(invoice_date) as month,
							  YEAR(invoice_date) as year,
							  "" as money_receipt,
							  "" as collection_remarks
							FROM
							  mas_invoices
							LEFT JOIN tbl_client_types ON tbl_client_types.id=mas_invoices.client_type
							LEFT JOIN invoice_types ON invoice_types.id=mas_invoices.tbl_invoice_cat_id							
							WHERE
							  mas_invoices.customer_id="'.$customer.'" AND invoice_date>="'.$Fdate.'"  AND invoice_date<="'.$tdate.'"
							UNION
							SELECT
								"" as invoice_number,
								"" as invoice_date,
								DATE_FORMAT(collection_date,"%d-%m-%Y") as collection_date,
								collection_date as orderdate,
								"0" as total,
								coll_amount as ctotal,
								"0" as other_adjustment,
								discoun_amnt as discoun_amnt,
								aitadjust as ait_adjustment,
							    vatadjust as vat_adjust_ment,
								downtimeadjust as downtimeadjust,
								"CO" as type,
								"Collection" as invtype,
								"" as package,
								"" as month,
								"" as year,
								money_receipt as money_receipt,
								mas_collections.remarks as collection_remarks
							FROM
								mas_collections									
							WHERE    
							   mas_collections.customer_id="'.$customer.'"	AND collection_date>="'.$Fdate.'" AND collection_date<="'.$tdate.'"   
							 ORDER BY orderdate ASC');
		

        return view("pages.billing.reports.clientLedger", compact("menus", "zones", "client_types", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth", "invoiceYear", "invoiceTmonth", "invoiceTyear"));
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