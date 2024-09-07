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
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use function App\Helpers\pick;
use function App\Helpers\dateDifference;

use App\Models\TblStatusType;
use App\Models\TblBillType;
use App\Models\TblBandwidthPlan;
use Barryvdh\DomPDF\Facade\Pdf;



class MonthlyInvoiceController extends Controller
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
		

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();

        $cust_invoices = MasInvoice::query()
						->leftJoin('customers', 'customers.id', '=', 'mas_invoices.customer_id')
						->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'mas_invoices.serv_id')
						->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'mas_invoices.client_type')
						->leftJoin('tbl_srv_types', 'trn_clients_services.srv_type_id', '=', 'tbl_srv_types.id')
        ->select([
								'mas_invoices.invoice_number',
								'trn_clients_services.user_id',
								'mas_invoices.invoice_number',
								'mas_invoices.invoice_date',
								DB::raw('DATE_FORMAT(mas_invoices.invoice_date, "%d/%m/%Y") AS invoicedate'),								
								'mas_invoices.bill_number',
								'mas_invoices.invoice_cat',
								'mas_invoices.client_id',
								'trn_clients_services.user_id',
								'customers.mobile1',
								'customers.present_address',
								'mas_invoices.client_type',
								'customers.customer_name',
					DB::raw("if(mas_invoices.tbl_invoice_cat_id='1',(SELECT sum(arr.total_bill)-(sum(arr.collection_amnt)+sum(arr.ait_adjustment)+sum(arr.vat_adjust_ment)+sum(arr.other_adjustment)+sum(arr.vat_adjust_ment)+sum(arr.ait_adjustment)+sum(arr.downtimeadjust))
									FROM mas_invoices as arr
									WHERE arr.invoice_date < '$invoiceYear-$invoiceMonth-01' AND arr.client_id = mas_invoices.client_id  group by client_id),0) as cur_arrear"),								
								'mas_invoices.bill_amount', 
								'mas_invoices.total_bill',
								'mas_invoices.unit',
								'mas_invoices.collection_amnt',
								'mas_invoices.discount_amnt',
								'mas_invoices.other_adjustment',
								'mas_invoices.vat_adjust_ment',
								'mas_invoices.ait_adjustment',
								'mas_invoices.downtimeadjust',
								'mas_invoices.ip_number',
								'mas_invoices.rate_amnt',
								'tbl_client_types.name',
								'tbl_srv_types.srv_name',
        ])
        ->where(DB::raw('month(mas_invoices.invoice_date)'), $invoiceMonth);
			$cust_invoices->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceYear);
 
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
        
        


        return view("pages.billing.reports.monthlyInvoiceReport", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth", "invoiceYear","selectedBranch" , "selectedcategory"));
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

		$menus = Menu::get();
			$zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
			$client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
			$status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
			$customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
			$branches = TblSuboffice::where('status',1)->get();

			$cust_invoices = MasInvoice::query()
							->leftJoin('customers', 'customers.id', '=', 'mas_invoices.customer_id')
							->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'mas_invoices.serv_id')
							->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'mas_invoices.client_type')
							->leftJoin('tbl_srv_types', 'trn_clients_services.srv_type_id', '=', 'tbl_srv_types.id')
			->select([
									'mas_invoices.invoice_number',
									'trn_clients_services.user_id',
									'mas_invoices.invoice_number',
									'mas_invoices.invoice_date',
									DB::raw('DATE_FORMAT(mas_invoices.invoice_date, "%d/%m/%Y") AS invoicedate'),								
									'mas_invoices.bill_number',
									'mas_invoices.invoice_cat',
									'mas_invoices.client_id',
									'trn_clients_services.user_id',
									'customers.mobile1',
									'customers.present_address',
									'mas_invoices.client_type',
									'customers.customer_name',
						DB::raw("if(mas_invoices.tbl_invoice_cat_id='1',(SELECT sum(arr.total_bill)-(sum(arr.collection_amnt)+sum(arr.ait_adjustment)+sum(arr.vat_adjust_ment)+sum(arr.other_adjustment)+sum(arr.vat_adjust_ment)+sum(arr.ait_adjustment)+sum(arr.downtimeadjust))
										FROM mas_invoices as arr
										WHERE arr.invoice_date < '$invoiceYear-$invoiceMonth-01' AND arr.client_id = mas_invoices.client_id  group by client_id),0) as cur_arrear"),								
									'mas_invoices.bill_amount', 
									'mas_invoices.total_bill',
									'mas_invoices.unit',
									'mas_invoices.collection_amnt',
									'mas_invoices.discount_amnt',
									'mas_invoices.other_adjustment',
									'mas_invoices.vat_adjust_ment',
									'mas_invoices.ait_adjustment',
									'mas_invoices.downtimeadjust',
									'mas_invoices.ip_number',
									'mas_invoices.rate_amnt',
									'tbl_client_types.name',
									'tbl_srv_types.srv_name',
			])
			->where(DB::raw('month(mas_invoices.invoice_date)'), $invoiceMonth);
				$cust_invoices->where(DB::raw('year(mas_invoices.invoice_date)'), $invoiceYear);
	
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

		if ($request->action == 'search') 
		{
			return view("pages.billing.reports.monthlyInvoiceReport", compact("menus", "zones", "client_category", "status_types", "customers", "cust_invoices", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches" ,"invoiceMonth", "invoiceYear","selectedBranch", "selectedcategory"));
		}
		else if($request->action == 'pdf')
		{
			$pdf = Pdf::loadView('pages.pdf.reports.monthlyInvoiceReport', compact("cust_invoices", "invoiceMonth", "invoiceYear"))->setPaper('a4', 'portrait');
	        return $pdf->download('invoices.pdf');
	        return $pdf->stream();
		}
		else if($request->action == 'excel')
		{
			$filename = 'Invoices.xlsx';
			
			$export = new ExcelExport(collect($cust_invoices));
			$header = ["Sl", "Invoice No", "Client ID"];
			//dd($cust_invoices);

	        return Excel::download($export, $filename,null,$header);
			
    	    //return redirect( Storage::url("{$filename}"));
		}



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