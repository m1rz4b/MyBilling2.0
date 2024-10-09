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
use App\Models\MasCostCenter;
use App\Models\TrnBank;



class GenChequeVoucherController extends Controller
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
		$selectedcostcenter= -1;
		$selectedbank= -1;
		$selectedbankaccount= -1;
	
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
		$costcenters = MasCostCenter::get();
		$banks = MasBank::get();
		$bankaccounts = TrnBank::get();

 $collection_lists = MasCollection::query()
						->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->leftJoin('mas_banks', 'mas_banks.id', '=', 'mas_collections.bank_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						
        ->select([		
						DB::raw("if(mas_collections.pay_type='C',mas_collections.coll_amount,0) as  ccollamnt"),
						DB::raw("if(mas_collections.pay_type='Q',mas_collections.coll_amount,0) as  qcollamnt"),
						DB::raw("if(mas_collections.pay_type='D',mas_collections.coll_amount,0) as  dcollamnt"),
						DB::raw("DATE_FORMAT(mas_collections.collection_date,'%d/%m/%Y') as collection_date"),
						DB::raw("mas_collections.coll_amount+mas_collections.adv_rec as collamnt"),
						'mas_collections.journal_id',
						'mas_collections.id as collection_id',
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
		$collection_lists->where('pay_type','Q');
		$collection_lists->where('journal_id',NULL);
		
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

        return view("pages.accounts.genChequeVoucher", compact("menus", "zones", "client_category", "status_types", "customers", "collection_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","end_date","selectedBranch","selectedcategory","costcenters","banks","bankaccounts","selectedcostcenter","selectedbank","selectedbankaccount"));
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
		
		$messages = [
            'required' => 'Please select atleast one :attribute',
        ];
        $data = $request->validate([
            'collection_id' => 'required',
			'costcenter_id' => 'required',
            
        ],$messages);
		
		$selectedIds=$request->collection_id;
		
		$selectedcostcenter= $request->costcenter_id;
		$selectedbank= $request->bank_id;
		$selectedbankaccount= $request->bank_ac_id;
		
		$txtcost_code=$selectedcostcenter;
		$accountnumber=$selectedbankaccount;
		
        $collectionsSql="SELECT * 
        FROM mas_collections 
        Where mas_collections.id in (".implode(',',$selectedIds).")";
        $collections = DB::select($collectionsSql);

		foreach ($collections as $collection) {
			$crgl='';
			$crcomment='';
			if($collection->adv_stat=='1'){
				$crgl='20503';
				$crcomment='Advance collection';	
				}
				else{
				$crgl='10401';
				$crcomment='Accounts Receiveable';
			}
	
	//		$journalNo = pick("mas_latestjournalnumber","CR",null);
	$journalNo=pick('mas_latestjournalnumbers','CR',"")[0]->CR;
//$journalNo = 1;
	       $masjournal = [
				'journalno' => $journalNo,
				'journaldate' => $collection->collection_date,
				'moneyreceiptno' => $collection->money_receipt,
				'paytype' => $collection->pay_type,
				'journaltype' => 'REC',
				'bankid' => $collection->bank_id,
				'accountno' => $accountnumber,
				'chequeno' => $collection->cheque_no,
				'partyid' => $collection->customer_id,
				'remarks' => 'Being the amount received against sale.'		
               ];
			$result =  DB::table('mas_journals')->insert($masjournal);
			
        $lastId = DB::getPdo()->lastInsertId();
		
		$trnjournal = [
				'glcode' => $crgl,
				'amount' => $collection->coll_amount,
				'ttype' => 'Cr',
				'remarks' => $crcomment,
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
               ];
		DB::table('trn_journals')->insert($trnjournal);
		
		if($collection->vatadjust>0 || $collection->aitadjust>0 || $collection->downtimeadjust>0){
			$trnjournal = [
					'glcode' => '10401',
					'amount' => $collection->vatadjust+$collection->aitadjust+$collection->downtimeadjust,
					'ttype' => 'Cr',
					'remarks' => 'JV For VAT/AIT/Down Time Adjustment',
					'cost_code' =>$txtcost_code,
					'journalId' =>$lastId

					];
			DB::table('trn_journals')->insert($trnjournal);
			}
			
			
			if($collection->adv_rec>0){
			$collection->coll_amount=$collection->coll_amount+$collection->adv_rec;	
			}
		$trnjournal = [
				'glcode' => '10202',
				'amount' => $collection->coll_amount,
				'ttype' => 'Dr',
				'remarks' => 'Cash receive against invoice',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId

			];
		DB::table('trn_journals')->insert($trnjournal);
			
			if($collection->adv_rec>0){
			$trnjournal = [
				'glcode' => 20503,
				'amount' => $collection->adv_rec,
				'ttype' => 'Cr',
				'remarks' => 'Advance collection',
				'cost_code' =>$txtcost_code,
				'journalId' =>$lastId
			];
		DB::table('trn_journals')->insert($trnjournal);	
			}
			
			if($collection->vatadjust>0){
			$trnjournal = [
						'glcode' => '40903',
						'amount' => $collection->vatadjust,
						'ttype' => 'Dr',
						'remarks' => 'JV For VATdjustment',
						'cost_code' =>$txtcost_code,
						'journalId' =>$lastId
				];
		DB::table('trn_journals')->insert($trnjournal);
				}
				
			if($collection->aitadjust>0){
			$trnjournal = [
						'glcode' => '40909',
						'amount' => $collection->aitadjust,
						'ttype' => 'Dr',
						'remarks' => 'JV For AIT Adjustment',
						'cost_code' =>$txtcost_code,
						'journalId' =>$lastId
				];
			DB::table('trn_journals')->insert($trnjournal);
				}
				
			if($collection->downtimeadjust>0){
			$trnjournal = [
						'glcode' => '41102',
						'amount' => $collection->downtimeadjust,
						'ttype' => 'Dr',
						'remarks' => 'JV For Down Time Adjustment',
						'cost_code' =>$txtcost_code,
						'journalId' =>$lastId
				];
		DB::table('trn_journals')->insert($trnjournal);
				}
	//	$journal_id=createJournal($journal,'CR');
	
		$updatemasjournal = "UPDATE mas_collections SET journal_id = '$lastId' WHERE id = '$collection->id'";
        DB::select($updatemasjournal);
		
		$new_journalNo=$journalNo+1;
		$latestjournalnumber = "UPDATE mas_latestjournalnumbers SET CR = $new_journalNo";
        DB::select($latestjournalnumber);			
				
	}
		 return redirect('/genchequevoucher')->with('success', 'Credit Voucher of Cheque Generated Successfully');
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
		
		$selectedcostcenter= $request->costcenter_id;
		$selectedbank= $request->bank_id;
		$selectedbankaccount= $request->bank_ac_id;
		$selectedonlineplatfrom = $request->payment_from;
		
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
		$costcenters = MasCostCenter::get();
		$banks = MasBank::get();
		$bankaccounts = TrnBank::get();

         $collection_lists = MasCollection::query()
						->leftJoin('customers', 'customers.id', '=', 'mas_collections.customer_id')
						->leftJoin('mas_banks', 'mas_banks.id', '=', 'mas_collections.bank_id')
						->Join('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
						
        ->select([		
						DB::raw("if(mas_collections.pay_type='C',mas_collections.coll_amount,0) as  ccollamnt"),
						DB::raw("if(mas_collections.pay_type='Q',mas_collections.coll_amount,0) as  qcollamnt"),
						DB::raw("if(mas_collections.pay_type='D',mas_collections.coll_amount,0) as  dcollamnt"),
						DB::raw("DATE_FORMAT(mas_collections.collection_date,'%d/%m/%Y') as collection_date"),
						DB::raw("mas_collections.coll_amount+mas_collections.adv_rec as collamnt"),
						'mas_collections.journal_id',
						'mas_collections.id as collection_id',
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
		$collection_lists->where('pay_type','Q');
		$collection_lists->where('journal_id',NULL);
		
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

          return view("pages.accounts.genChequeVoucher", compact("menus", "zones", "client_category", "status_types", "customers", "collection_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","end_date","selectedBranch","selectedcategory","costcenters","banks","bankaccounts","selectedcostcenter","selectedbank","selectedbankaccount"));
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