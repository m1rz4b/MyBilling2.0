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
use App\Models\InvoiceType;




class InvoicePrintController extends Controller
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
		$selectedInvoiceCat= -1;
	
		$invoiceMonth = date("m");
		$invoiceYear = date("Y");
		
		$subzone =  -1;
		$selectedcategory = -1;
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();
		$invoicecategorys = InvoiceType::where('status',1)->get();

 $client_list = MasInvoice::query()
						->Join('trn_invoices', 'trn_invoices.invoiceobject_id', '=', 'mas_invoices.id')
						->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'mas_invoices.serv_id')
						->leftJoin('tbl_srv_types', 'tbl_srv_types.id', '=', 'trn_clients_services.srv_type_id')
        ->select([
								  'trn_invoices.billing_year',
								  'trn_invoices.billing_month',
								  'trn_invoices.billingdays',
								  'trn_invoices.from_date',
								  'trn_invoices.to_date',
								  'trn_invoices.camnt',
								  'trn_invoices.cvat',
								  'trn_invoices.total',
								  'tbl_srv_types.srv_name',
								  'trn_invoices.discount_comments',
								  'trn_clients_services.user_id',
								  'mas_invoices.tbl_invoice_cat_id',
								  'mas_invoices.invoice_date',
								  'mas_invoices.total_bill',		
        ]);
	//	->orderBy('customers.id');
			//		order by user_id
			
	
        if ($selectedCustomer>-1) {
			$client_list->where(DB::raw('year(mas_invoices.customer_id)'), $selectedCustomer);
        }
		if ($invoiceMonth>-1) {
			$client_list->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceMonth);
        }
		if ($invoiceYear>-1) {
			$client_list->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceYear);
        }

	//	if ($selectedInvoiceCat>-1) {
	//		$client_list->where('mas_invoices.tbl_invoice_cat_id', $selectedInvoiceCat);
   //     }
		
		
        $client_list = $client_list->get();

        return view("pages.billing.reports.invoicePrint", compact("menus", "zones", "client_category", "status_types", "customers", "client_list", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth","invoiceYear","selectedBranch","selectedcategory","clienttypes", "selectedInvoiceCat","invoicecategorys"));
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
		$selectedInvoiceCat= $request->invoice_cat;
		
		$selectedBranch = $request->branch;
		$selectedcategory = $request->client_category;

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$clienttypes = TblClientType::where('status',1)->get();
		$invoicecategorys = InvoiceType::where('status',1)->get();

         $client_list = MasInvoice::query()
						->Join('trn_invoices', 'trn_invoices.invoiceobject_id', '=', 'mas_invoices.id')
						->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'mas_invoices.serv_id')
						->leftJoin('tbl_srv_types', 'tbl_srv_types.id', '=', 'trn_clients_services.srv_type_id')
        ->select([
								  'trn_invoices.billing_year',
								  'trn_invoices.billing_month',
								  'trn_invoices.billingdays',
								  'trn_invoices.from_date',
								  'trn_invoices.to_date',
								  'trn_invoices.camnt',
								  'trn_invoices.cvat',
								  'trn_invoices.total',
								  'tbl_srv_types.srv_name',
								  'trn_invoices.discount_comments',
								  'trn_clients_services.user_id',
								  'mas_invoices.tbl_invoice_cat_id',
								  'mas_invoices.invoice_date',
								  'mas_invoices.total_bill',		
        ]);
	//	->orderBy('customers.id');
			//		order by user_id
        if ($selectedCustomer>-1) {
            $client_list->where('mas_invoices.customer_id', $selectedCustomer);
        }
		if ($invoiceMonth>-1) {
			$client_list->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceMonth);
        }
		if ($invoiceYear>-1) {
			$client_list->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceYear);
        }
		
	//	if ($selectedInvoiceCat>-1) {
//			$client_list->where('mas_invoices.tbl_invoice_cat_id', $selectedInvoiceCat);
   //     }
	
        $client_list = $client_list->get();

        return view("pages.billing.reports.invoicePrint", compact("menus", "zones", "client_category", "status_types", "customers", "client_list", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth","invoiceYear","selectedBranch","selectedcategory","clienttypes", "selectedInvoiceCat","invoicecategorys"));
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