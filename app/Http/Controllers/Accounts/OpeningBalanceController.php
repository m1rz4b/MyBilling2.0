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
use App\Models\MasSupplier;
use App\Models\MasEmployee;
use App\Models\GlCode;
use App\Models\MasJournal;





class OpeningBalanceController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
		
		$selectedBranch = -1;
		$selectedCustomer = -1;
		$start_date = date("Y-m-d");
		$selectedgl_code = "";
		$selectedDate = "1970-01-01";
		
        $menus = Menu::get();
		$costcenters = MasCostCenter::where('pid','<>',-1)->get();
		$trnbanks = TrnBank::get();
		$masbanks = MasBank::get();
		$massuppliers = MasSupplier::get();
		$masemployees = Masemployee::get();
		$glcodes = GlCode::get();
		$sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
		$customers = TrnClientsService::select('id', 'user_id')->get();
		$mas_gls = GlCode::where(DB::raw('substr(gl_code,1,2)'),'<>', '00000')->orderBy ('description')->get();


 $masjournals = MasJournal::query()
						->leftJoin('trn_journals', 'trn_journals.id', '=', 'mas_journals.id')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
						->leftJoin('mas_suppliers', 'mas_suppliers.id', '=', 'mas_journals.supplierid')
						->leftJoin('mas_employees', 'mas_employees.id', '=', 'mas_journals.emp_id')
						->leftJoin('trn_banks', 'trn_banks.account_no', '=', 'mas_journals.accountno')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
	
	
        ->select([		
				  'mas_journals.id',
				  'mas_journals.journalno',
				  'mas_journals.journaldate',
				  'mas_journals.bankid',
				  'mas_journals.accountno',
				  'mas_journals.partyid',
				 'mas_journals.supplierid',
				  'mas_journals.emp_id',
				  'mas_journals.remarks',
				  'trn_journals.ttype',
				  'trn_journals.glcode',
				'trn_journals.amount',
				  'mas_employees.emp_name',
				  'mas_suppliers.clients_name',
				  'customers.customer_name as cname',
                  'trn_banks.account_no',
				  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) as debit"),
				  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) as credit"),
				'gl_codes.description',
				'mas_cost_centers.description as costcenter_dec',
        ])
		->orderBy('journaldate', 'desc');

		$masjournals->where('mas_journals.remarks','Opening Balance');

		if ($selectedgl_code){
            $masjournals->where('trn_journals.glcode',$selectedgl_code);
        }
		if ($selectedDate) {
           $masjournals->where('mas_journals.journaldate',$selectedDate);
        }
		
        $masjournals = $masjournals->get();

        return view("pages.accounts.openingBalance", compact("menus", "selectedDate","costcenters","trnbanks","masbanks","massuppliers","masemployees","glcodes","mas_gls","sub_offices","customers","masjournals"));
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
			'gl_code' => 'required|gt:0',
			'txtjournaldate' => 'required',
			'txtAmount' => 'required',
			],['gl_code.gt'=>'gl_code is required']);
	/*		
			$request->validate([
			'txtJournalType' => 'required',
			'txtAmount' => 'required',
			'txtcost_code_from' => 'required|gt:0',
			'txtcost_code_to' => 'required|gt:0',
			],['txtcost_code_from.gt'=>'Cost Center from is required','txtcost_code_to.gt'=>'Cost Center To is required' ]);
	*/	
		$selectedcostcenter=$request->txtcost_code;
		$start_date=$request->txtjournaldate;
		$txtcost_code=$selectedcostcenter;
		$txtremarks='Opening Balance';
//		dd($request->customer_id);
		
		$type=substr($request->gl_code, 0, 1);
		if($type=='1'){
		$ttype='Dr';
		}
		elseif($type=='2'){
		$ttype='Cr';	
		} 

try {
    DB::beginTransaction(); // <= Starting the transaction

	       $masjournal = [
				'journalno' => 1,
				'journaldate' => $request->txtjournaldate,
				'journaltype' => 'JV',
				'bankid' => $request->cboToBank,
				'accountno' => $request->cboToAccountNo,
				'partyid' => $request->customer_id,
				'supplierid' => $request->txtsupplierid,
				'emp_id' => $request->emp_id,
				'remarks' => $txtremarks,
				'journal_status' => '0'
               ];
	   
		//	 dd($masjournal);
			$result =  DB::table('mas_journals')->insert($masjournal);
			$lastId = DB::getPdo()->lastInsertId();
		
				$trnjournal = [
				'journalId' =>$lastId,
				'slno' =>'1',
				'glcode' => $request->gl_code,
				'amount' => $request->txtAmount,
				'ttype' => $ttype,
				'remarks' =>  $txtremarks,
				'cost_code' =>$request->txtcost_code
               ];
   
		DB::table('trn_journals')->insert($trnjournal);
		
		 if($request->gl_code== 10401)
		 {
							$masinvoice = [
									'invoice_date' => $request->txtjournaldate,									
									'customer_id' => $request->customer_id,
									'remarks' => $txtremarks,
									'bill_amount' => $request->txtAmount,
									'total_bill' => $request->txtAmount,
									'invoice_cat' => $request->gl_code,
									'journal_id' => $lastId,
									'journal_status' => 1
									];
							DB::table('mas_invoices')->insert($masinvoice);	
									
		 } elseif($request->gl_code==20501)
		 {
			
						$massupplierinvoice = [			 
										'invoice_date' => $request->txtjournaldate,
										'client_id' => $request->txtsupplierid,
										'remarks' => $txtremarks,
										'bill_amount' => $request->txtAmount,
										'total_bill' => $request->txtAmount,
										'journal_id' => $lastId,
										'journal_status' =>1,
										'cost_code' => $request->txtcost_code
							];
							DB::table('mas_supplier_invoices')->insert($massupplierinvoice);						
		 }
	DB::commit(); // <= Commit the changes
	return redirect('/openingbalance')->with('success','JV Generated Successfully');
	} catch (\Exception $e) {
    report($e);
 //   dd($e);
    DB::rollBack(); // <= Rollback in case of an exception
	return redirect('/openingbalance')->withErrors(['JV Creation Failed']);
	}
	//	 return redirect('/openingbalance')->with('success','JV Generated Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
		$selectedgl_code = $request->gl_codes;
		$selectedDate = $request->txtjournaldate;

        $menus = Menu::get();
		$costcenters = MasCostCenter::where('pid','<>',-1)->get();
		$trnbanks = TrnBank::get();
		$masbanks = MasBank::get();
		$massuppliers = MasSupplier::get();
		$masemployees = Masemployee::get();
		$glcodes = GlCode::get();
		$sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
		$customers = TrnClientsService::select('id', 'user_id')->get();
		$mas_gls = GlCode::where(DB::raw('substr(gl_code,1,2)'),'<>', '00000')->orderBy ('description')->get();

         $masjournals = MasJournal::query()
						->leftJoin('trn_journals', 'trn_journals.journalid', '=', 'mas_journals.id')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
						->leftJoin('mas_suppliers', 'mas_suppliers.id', '=', 'mas_journals.supplierid')
						->leftJoin('mas_employees', 'mas_employees.id', '=', 'mas_journals.emp_id')
						->leftJoin('trn_banks', 'trn_banks.account_no', '=', 'mas_journals.accountno')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.cost_code', '=', 'trn_journals.cost_code')
						
        ->select([		
				  'mas_journals.id',
				  'mas_journals.journalno',
				  'mas_journals.journaldate',
				  'mas_journals.bankid',
				  'mas_journals.accountno',
				  'mas_journals.partyid',
				 'mas_journals.supplierid',
				  'mas_journals.emp_id',
				  'mas_journals.remarks',
				  'trn_journals.ttype',
				  'trn_journals.glcode',
					'trn_journals.amount',
				  'mas_employees.emp_name',
				  'mas_suppliers.clients_name',
				  'customers.customer_name as cname',
                  'trn_banks.account_no',
				  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) as debit"),
				  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) as credit"),
				'gl_codes.description',
				'mas_cost_centers.description as costcenter_dec',
        ])
		
		->orderBy('journaldate', 'desc');

		$masjournals->where('mas_journals.remarks','Opening Balance');

		if ($selectedgl_code>=1){
            $masjournals->where('trn_journals.glcode',$selectedgl_code);
        }
		if ($selectedDate) {
           $masjournals->where('mas_journals.journaldate',$selectedDate);
        }
		
        $masjournals = $masjournals->get();

//dd($masjournals);
        return view("pages.accounts.openingBalance", compact("menus", "selectedDate","costcenters","trnbanks","masbanks","massuppliers","masemployees","glcodes","mas_gls","sub_offices","customers","masjournals"));
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
	 public function destroy(MasJournal $openingbalance)
    {
        //
        $darea = MasJournal::find($openingbalance -> id);
        $darea->delete();
		
		$openingbalance_id = $openingbalance -> id;
		
		$deletetrn_journals = "delete from  trn_journals where journalid= $openingbalance_id";
        DB::select($deletetrn_journals);	
		
		
		$deletemas_invoices = "delete from  mas_invoices where journal_id= $openingbalance_id";
        DB::select($deletemas_invoices);	
		
		$deletemas_supplier_invoice = "delete from  mas_supplier_invoices where journal_id= $openingbalance_id";
        DB::select($deletemas_supplier_invoice);
		
        return redirect() -> route("openingbalance.index") -> with('success', 'Area deleted successfully');
    }
	
	
}