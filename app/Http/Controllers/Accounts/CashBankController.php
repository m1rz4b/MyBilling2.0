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
use App\Models\MasSupplier;
use App\Models\MasCostCenter;
use App\Models\MasJournal;
use App\Models\TrnJournal;



class CashBankController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $selectedCostcenter = -1;
		$CostcenterName="";
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		$costcenters = MasCostCenter::where('pid','<>',-1)->get();
		
        $menus = Menu::get();

		$trnjournals = TrnJournal::query()
						->Join('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
				'mas_journals.id',
			  'mas_journals.journalno',
			  'mas_journals.journaltype',
			  'mas_journals.paytype',
			  'mas_journals.partyid',
			  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
			  'trn_journals.ttype',
			  'trn_journals.amount',
				'mas_journals.remarks as remarks',
				'trn_journals.remarks as tremarks',			 
			  'mas_cost_centers.description',
			  'gl_codes.gl_code',
		])
		->orderBy('mas_journals.id')
		->orderBy('mas_journals.journaldate')
		->orderBy('mas_journals.journalno')
		->orderBy('mas_journals.journaltype');

		 $trnjournals->where('mas_journals.journaldate','>=',$start_date);
		 $trnjournals->where('mas_journals.journaldate','<=',$end_date);
		 $trnjournals->whereIn('trn_journals.glcode',[10201,10202]);

		if ($selectedCostcenter>=1){
            $trnjournals->where('trn_journals.cost_code',$selectedCostcenter);
        }
        $trnjournals = $trnjournals->get();
		
		
		$queryopencash = TrnJournal::query()
						->leftJoin('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrCashAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrCashAmount"),
			  'trn_journals.ttype as trtype',
			'gl_codes.gl_code as opengl',
		]);
		 $queryopencash->where('mas_journals.journaldate','<',$start_date);
		 $queryopencash->where('trn_journals.glcode',10101);

		if ($selectedCostcenter>=1){
            $queryopencash->where('trn_journals.cost_code',$selectedCostcenter);
        }
        $queryopencash = $queryopencash->get();
		
		$queryopenbank = TrnJournal::query()
						->leftJoin('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrBankAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrBankAmount"),
			  'trn_journals.ttype as trtype',
			'gl_codes.gl_code as opengl',
		]);
		 $queryopenbank->where('mas_journals.journaldate','<',$start_date);
		 $queryopenbank->where('trn_journals.glcode',10202);

		if ($selectedCostcenter>=1){
            $queryopenbank->where('trn_journals.cost_code',$selectedCostcenter);
        }
        $queryopenbank = $queryopenbank->get();
		

        return view("pages.accounts.cashBank", compact("menus","start_date","end_date","selectedCostcenter","costcenters","trnjournals","queryopencash","queryopenbank","CostcenterName"));
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
		
		
		$selectedCostcenter=$request->cost_center;
		$start_date=$request->start_date;
		$end_date=$request->end_date;

		$costcenters = MasCostCenter::where('pid','<>',-1)->get();
		
		$CostcenterName="";
		if($request->cost_center>=1) {
		$CostcenterName=pick('mas_cost_centers','description','id="'.$request->cost_center.'"');
		$CostcenterName=$CostcenterName[0]->description;
		}

        $menus = Menu::get();

		$trnjournals = TrnJournal::query()
						->Join('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
				'mas_journals.id',
			  'mas_journals.journalno',
			  'mas_journals.journaltype',
			  'mas_journals.paytype',
			  'mas_journals.partyid',
			  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
			  'trn_journals.ttype',
			  'trn_journals.amount',
			 'mas_journals.remarks as remarks',
			 'trn_journals.remarks as tremarks',			 
			  'mas_cost_centers.description',
			  'gl_codes.gl_code',
		])
		->orderBy('mas_journals.id')
		->orderBy('mas_journals.journaldate')
		->orderBy('mas_journals.journalno')
		->orderBy('mas_journals.journaltype');
		

		 $trnjournals->where('mas_journals.journaldate','>=',$start_date);
		 $trnjournals->where('mas_journals.journaldate','<=',$end_date);
		 $trnjournals->whereIn('trn_journals.glcode',[10201,10202]);

		if ($selectedCostcenter>=1){
            $trnjournals->where('trn_journals.cost_code',$selectedCostcenter);
        }

        $trnjournals = $trnjournals->get();

       $queryopencash = TrnJournal::query()
						->leftJoin('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrCashAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrCashAmount"),
			  'trn_journals.ttype as trtype',
			'gl_codes.gl_code as opengl',
		]);
		 $queryopencash->where('mas_journals.journaldate','<',$start_date);
		 $queryopencash->where('trn_journals.glcode',10201);

		if ($selectedCostcenter>=1){
            $queryopencash->where('trn_journals.cost_code',$selectedCostcenter);
        }
        $queryopencash = $queryopencash->get();
		
		$queryopenbank = TrnJournal::query()
						->leftJoin('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
        ->select([	
			  DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrBankAmount"),
			  DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrBankAmount"),
			  'trn_journals.ttype as trtype',
			'gl_codes.gl_code as opengl',
		]);
		 $queryopenbank->where('mas_journals.journaldate','<',$start_date);
		 $queryopenbank->where('trn_journals.glcode',10202);

		if ($selectedCostcenter>=1){
            $queryopenbank->where('trn_journals.cost_code',$selectedCostcenter);
        }
        $queryopenbank = $queryopenbank->get();
		
//dd($CostcenterName);
        return view("pages.accounts.cashBank", compact("menus","start_date","end_date","selectedCostcenter","costcenters","trnjournals","queryopencash","queryopenbank","CostcenterName"));
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