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



class TransferVoucherController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$start_date = date("Y-m-d");
        $menus = Menu::get();
		$maslatestjournalnumbers=pick('mas_latestjournalnumbers','TR',"")[0]->TR;
		$maslatestjournalnumbers = $maslatestjournalnumbers+1;
		$costcenters = MasCostCenter::where('pid','<>',-1)->get();
		$trnbanks = TrnBank::get();
		$masbanks = MasBank::get();
			
        return view("pages.accounts.transferVoucher", compact("menus", "maslatestjournalnumbers","start_date","costcenters","trnbanks","masbanks"));
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
		
			$request->validate([
			'mremarks' => 'required',
			'txtJournalType' => 'required',
			'txtAmount' => 'required',
			'txtcost_code_from' => 'required|gt:0',
			'txtcost_code_to' => 'required|gt:0',
			],['txtcost_code_from.gt'=>'Cost Center from is required','txtcost_code_to.gt'=>'Cost Center To is required' ]);
		
		$selectedIds=$request->collection_id;
		$selectedcostcenter=$request->costcenter_id;
		$start_date=$request->start_date;
		
		
		
		$txtcost_code=$selectedcostcenter;
		
		$new_journalNo= $request->journalno;
		
//dd('test');
	
	//		$journalNo = pick("mas_latestjournalnumber","CR",null);
//$journalNo = 1;
		if($request->rdopayto=='Q')
		{
	       $masjournal = [
				'journalno' => $request->journalno,
				'journaltype' => $request->txtJournalType,
				'journaldate' => $request->start_date,
				'paytype' => $request->rdopayto,
				'bankid' => $request->cboBank,
				'accountno' => $request->cboAccountNo,
				'chequeno' => $request->cqno,
				'chequedate' => $request->txtChequeDate,
				'remarks' => $request->mremarks,
				'tobankid' => $request->cboToBank,		
				'toaccountno' => $request->cboToAccountNo,
				'journal_status' => '0'
               ];
		}else{
		$masjournal = [
				'journalno' => $request->journalno,
				'journaltype' => $request->txtJournalType,
				'journaldate' => $request->start_date,
				'paytype' => $request->rdopayto,
				'remarks' => $request->mremarks,
				'tobankid' => $request->cboToBank,		
				'toaccountno' => $request->cboToAccountNo,
				'journal_status' => '0'
               ];
			}	   
		//	 dd($masjournal);
			$result =  DB::table('mas_journals')->insert($masjournal);
			
        $lastId = DB::getPdo()->lastInsertId();
		
		$latestjournalnumber = "UPDATE mas_latestjournalnumbers SET TR = $new_journalNo";
        DB::select($latestjournalnumber);
		
	$lastjournalid=pick('mas_journals','LAST_INSERT_ID() AS  JournalId',"")[0]->JournalId;
		
		
		$rdopayto=$request->rdopayto;
        if($rdopayto=="C"){
        $GLCode="10201";
        }else{
                $GLCode="10202";
			}
	
				$trnjournal = [
				'journalId' =>$lastjournalid,
				'slno' =>'1',
				'glcode' => $GLCode,
				'amount' => $request->txtAmount,
				'ttype' => 'Cr',
				'remarks' =>  $request->mremarks,
				'cost_code' =>$request->txtcost_code_from
               ];
		DB::table('trn_journals')->insert($trnjournal);
		
		
		$rdoTopayto=$request->rdoTopayto;
        if($rdoTopayto=="C"){
                $GLCode="10201";
        }else{
                $GLCode="10202";
		}
	
	$trnjournal = [
				'journalId' =>$lastjournalid,
				'slno' =>'2',
				'glcode' => $GLCode,
				'amount' => $request->txtAmount,
				'ttype' => 'Dr',
				'remarks' =>  $request->mremarks,
				'cost_code' =>$request->txtcost_code_to
               ];
		DB::table('trn_journals')->insert($trnjournal);
		
		 return redirect('/transfervoucher')->with('success','Credit Voucher Generated Successfully');
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
		$selectedcostcenter=$request->costcenter_id;

        $menus = Menu::get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_category = TblClientCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();
		$branches = TblSuboffice::where('status',1)->get();
		$costcenters = MasCostCenter::get();

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
		$collection_lists->where('pay_type','C');
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

        return view("pages.accounts.transferVoucher", compact("menus", "zones", "client_category", "status_types", "customers", "collection_lists", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer","branches","start_date","end_date","selectedBranch","selectedcategory","costcenters","selectedcostcenter"));
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