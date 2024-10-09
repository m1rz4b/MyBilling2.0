<?php

namespace App\Http\Controllers\Accounts;

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
use App\Models\MasCostCenter;



class ClientInvoicePostingController extends Controller
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
        $selectedCustomer = 1;
		$selectedBranch = -1;
		$selectedInvoiceCat= -1;
		$selectedcostcenter= -1;
	
//		$start_date = date("Y-m-d");
//		$end_date = date("Y-m-d");
		
		$invoiceMonth = date("m");
        $invoiceYear = date("Y");
		
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
		$invoicecategorys = InvoiceType::where('status',1)->get();
		$costcenters = MasCostCenter::get();

        $invoice_postings = MasInvoice::query()
						->Join('customers', 'customers.id', '=', 'mas_invoices.customer_id')
						->Join('invoice_types', 'invoice_types.id', '=', 'mas_invoices.tbl_invoice_cat_id')
						
        ->select([
		
							'mas_invoices.id as invoices_id',
							'mas_invoices.invoice_number',
							'mas_invoices.bill_number',
							'mas_invoices.client_type',
							DB::raw("DATE_FORMAT(mas_invoices.invoice_date,'%d/%m/%Y') as invoice_date"),
							'customers.customer_name as Company_Name',
							'mas_invoices.remarks',
							'mas_invoices.vat',
							'mas_invoices.vatper',
							'mas_invoices.bill_amount',
							'mas_invoices.total_bill',
							'mas_invoices.collection_amnt',
							'mas_invoices.ait_adjustment',
							'mas_invoices.ait_adj_date',
							'mas_invoices.other_adjustment',
							'mas_invoices.discount_amnt',
							'mas_invoices.discount_date',
							'mas_invoices.comments',
							'mas_invoices.receive_status',
							'mas_invoices.view_status',
							'mas_invoices.entry_by',
							'mas_invoices.entry_date',
							'mas_invoices.update_by',
							'mas_invoices.update_date',
							'mas_invoices.invoice_cat as cat',
							'invoice_types.invoice_type_name as invoice_cat',
							'customers.id as supplier_id',
        ])
		 ->where('journal_id',0)
		 ->where('journal_status',0)
		 ->where('customers.reseller_id','<=',0)
		->orderBy('invoice_date');
 
		$invoice_postings->where(DB::raw('MONTH(mas_invoices.invoice_date)'),$invoiceMonth);
		$invoice_postings->where(DB::raw('Year(mas_invoices.invoice_date)'),$invoiceYear);

		
		if ($selectedInvoiceCat>=1) {
            $invoice_postings->where('mas_invoices.tbl_invoice_cat_id', $selectedInvoiceCat);
        }
		
		if ($selectedBranch>=1) {
            $invoice_postings->where('customers.sub_office_id', $selectedBranch);
        }
		
		if ($selectedCustomer>=1) {
            $invoice_postings->where('mas_invoices.customer_id', $selectedCustomer);
        }
	
		
        $invoice_postings = $invoice_postings->get();

        return view("pages.accounts.clientInvoicePosting", compact("menus", "zones", "client_category", "status_types", "customers", "invoice_postings", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth","invoiceYear","selectedBranch","invoicecategorys","selectedInvoiceCat","costcenters","selectedcostcenter"));
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
		
        $menus = Menu::get();	
		
		    $request->validate([
            'collection_id' => 'required',
            'costcenter_id' => 'required|max:20',
			]);
		
		$selectedIds=$request->collection_id;
		$selectedcostcenter=$request->costcenter_id;
		
//		dd($selectedIds);
		
		$txtcost_code=$selectedcostcenter;
		
        $collectionsSql="SELECT * ,mas_invoices.id as invoice_id, customers.tbl_client_category_id, customers.customer_name
                FROM mas_invoices
                LEFT JOIN customers ON customers.id=mas_invoices.customer_id 
                WHERE mas_invoices.id in (" . implode(',', $selectedIds) . ")";
				
        $collections = DB::select($collectionsSql);
		
		foreach ($collections as $collection) {
			$glcode = '';
			
		if ($collection->tbl_invoice_cat_id == '1') {
			
		$journalNo=pick('mas_latestjournalnumbers','JV',"")[0]->JV;
        // Insert into Mas Journal ****
		
		 $masjournal = [
				'journalno' => $journalNo,
				'journaldate' => $collection->invoice_date,
		//		'moneyreceiptno' => $collection->money_receipt,
				'billno' => $collection->invoice_id,
				'journaltype' => 'JV',
				'partyid' => $collection->customer_id,
				'remarks' => 'Being the amount received against sale.'. $collection->customer_name				
               ];
			$result =  DB::table('mas_journals')->insert($masjournal);
			
			$lastId = DB::getPdo()->lastInsertId();

        if ($collection->tbl_client_category_id == 1) {
            $glcode = '30101';
        } elseif ($collection->tbl_client_category_id == 2) {
            $glcode = '30102';
        } elseif ($collection->tbl_client_category_id == 3) {
            $glcode = '30103';
        }elseif ($collection->tbl_client_category_id == 5) {
            $glcode = '30105';
		 }elseif ($collection->tbl_client_category_id == 6) {
            $glcode = '30106';
        }else{
			$glcode = '30204';
		}
        // Start Insert into Trn Journal ****
				$trnjournal = [
				'glcode' => $glcode,
				'amount' => $collection->total_bill,
				'ttype' => 'Cr',
				'remarks' => 'Monthly Bill',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
		DB::table('trn_journals')->insert($trnjournal);
		
        // Insert Accounts Receivable
        $trnjournal = [
				'glcode' => '10401',
				'amount' => $collection->total_bill,
				'ttype' => 'Dr',
				'remarks' => 'Monthly Bill',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
		DB::table('trn_journals')->insert($trnjournal);
		
		$updatemasjournal = "UPDATE mas_invoices SET journal_status = 1, journal_id = '$lastId' WHERE id = '$collection->invoice_id'";
        DB::select($updatemasjournal);
		
		$new_journalNo=$journalNo+1;
		$latestjournalnumber = "UPDATE mas_latestjournalnumbers SET JV = $new_journalNo";
        DB::select($latestjournalnumber);
			  
		//other adjustment start//	  
		if($collection->other_adjustment > 0 || $collection->discount_amnt>0){	  
		
		$journalNo=pick('mas_latestjournalnumbers','JV',"")[0]->JV;
		
		// Insert into Mas Journal ****
		 $masjournal = [
				'journalno' => $journalNo,
				'journaldate' => $collection->invoice_date,
		//		'moneyreceiptno' => $collection->money_receipt,
				'billno' => $collection->invoice_id,
				'journaltype' => 'JV',
				'partyid' => $collection->customer_id,
				'remarks' => 'Being the amount received against sale.'. $collection->customer_name				
               ];
			$result =  DB::table('mas_journals')->insert($masjournal);		  
				  
			
		
			// Start Insert into Trn Journal ****

		$trnjournal = [
				'glcode' => '10401',
				'amount' => $collection->other_adjustment+$collection->discount_amnt,
				'ttype' => 'Cr',
				'remarks' => 'Advanced/Discount Adjustment',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
		DB::table('trn_journals')->insert($trnjournal);			
			
			// Insert Accounts Expenses
			if($collection->other_adjustment>0){
			$trnjournal = [
				'glcode' => '20503',
				'amount' => $collection->other_adjustment,
				'ttype' => 'Dr',
				'remarks' => 'Advanced Adjustment',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
			   }
		DB::table('trn_journals')->insert($trnjournal);
			
			
			if($collection->discount_amnt>0){
				if($collection->other_adjustment>0){
					$sl=2;
					}else{
						$sl=1;
						}
						
		$trnjournal = [
				'glcode' => '30202',
				'amount' => $collection->discount_amnt,
				'ttype' => 'Dr',
				'remarks' => 'Discount Adjustment',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
		DB::table('trn_journals')->insert($trnjournal);	
			}	

		$new_journalNo=$journalNo+1;
		$latestjournalnumber = "UPDATE mas_latestjournalnumbers SET JV = $new_journalNo";
        DB::select($latestjournalnumber);			
		}		  
        
		}	
	}
		 return redirect('/clientinvoiceposting')->with('success', 'Credit Voucher Generated Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
		$selectedCustomer = 1;
		
		$messages = [
            'required' => 'Please select Invoice Category',
        ];
        $data = $request->validate([
            'invoice_cat' => 'required',
        ],$messages);
		
		
        $selectedZone = $request->zone;
        $selectedPackage = $request->package;
        $selectedCustomerStatus = $request->customer_status;
        $selectedCurrentStatus = $request->current_status;
        $selectedCustomer = $request->customer_id;
		$selectedInvoiceCat = $request->invoice_cat;
		$selectedcostcenter = $request->costcenter_id;
		$selectedBranch = $request->branch_id;
	//	$selectedcategory = $request->client_category;
		
	//	$start_date = $request->start_date;
	//	$end_date = $request->end_date;
		
		$invoiceMonth = $request->month;
        $invoiceYear = $request->year;
		
	//	$start_month = $request->month;
	//	$start_year = $request->year;
	//	$selectedDate=$start_year.'-'.$start_month.'-1'; 
		
		
	////	$start_date = date("Y-m-d");
    //    $last = date('Y-m-t', strtotime($selectedDate));
	//	$fast=date('Y-m-01', strtotime($selectedDate));
		 


        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$invoicecategorys = InvoiceType::where('status',1)->get();
		$costcenters = MasCostCenter::get();

        $invoice_postings = MasInvoice::query()
						->Join('customers', 'customers.id', '=', 'mas_invoices.customer_id')
						->Join('invoice_types', 'invoice_types.id', '=', 'mas_invoices.tbl_invoice_cat_id')
						
        ->select([
		
							'mas_invoices.id as invoices_id',
							'mas_invoices.invoice_number',
							'mas_invoices.bill_number',
							'mas_invoices.client_type',
							DB::raw("DATE_FORMAT(mas_invoices.invoice_date,'%d/%m/%Y') as invoice_date"),
							'customers.customer_name as Company_Name',
							'mas_invoices.remarks',
							'mas_invoices.vat',
							'mas_invoices.vatper',
							'mas_invoices.bill_amount',
							'mas_invoices.total_bill',
							'mas_invoices.collection_amnt',
							'mas_invoices.ait_adjustment',
							'mas_invoices.ait_adj_date',
							'mas_invoices.other_adjustment',
							'mas_invoices.discount_amnt',
							'mas_invoices.discount_date',
							'mas_invoices.comments',
							'mas_invoices.receive_status',
							'mas_invoices.view_status',
							'mas_invoices.entry_by',
							'mas_invoices.entry_date',
							'mas_invoices.update_by',
							'mas_invoices.update_date',
							'mas_invoices.invoice_cat as cat',
							'invoice_types.invoice_type_name as invoice_cat',
							'customers.id as supplier_id',
        ])
		 ->where('journal_id',0)
		 ->where('journal_status',0)
		 ->where('customers.reseller_id','<=',0)
		->orderBy('invoice_date');
 
		$invoice_postings->where(DB::raw('MONTH(mas_invoices.invoice_date)'),$invoiceMonth);
		$invoice_postings->where(DB::raw('Year(mas_invoices.invoice_date)'),$invoiceYear);

		
		if ($selectedInvoiceCat>=1) {
            $invoice_postings->where('mas_invoices.tbl_invoice_cat_id', $selectedInvoiceCat);
        }
	
		if ($selectedCustomer>=1) {
            $invoice_postings->where('mas_invoices.customer_id', $selectedCustomer);
        }
		
		if ($selectedBranch>=1) {
            $invoice_postings->where('customers.sub_office_id', $selectedBranch);
	//		$customers = Customer::select('id', 'customer_name')->where('sub_office_id',$selectedBranch)->orderBy('customer_name', 'asc')->get();
        }

        $invoice_postings = $invoice_postings->get();

        return view("pages.accounts.clientInvoicePosting", compact("menus", "zones", "client_category", "status_types", "customers", "invoice_postings", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","invoiceMonth","invoiceYear","selectedBranch","invoicecategorys","selectedInvoiceCat","costcenters","selectedcostcenter"));
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