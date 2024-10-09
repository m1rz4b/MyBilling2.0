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
use App\Models\GlCode;


class GeneralLedgerController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $selectedglcodes = -1;
		$glcodeName="";
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		$glcodes = GlCode::orderBy ('description')->get();
		
        $menus = Menu::get();

		$masjournals = MasJournal::query()
						->Join('trn_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
        ->select([	
	
						'mas_journals.id',
						  'mas_journals.journalno',
						 'mas_journals.journaltype',
						  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
						  DB::raw("if(trn_journals.remarks='',mas_journals.remarks,trn_journals.remarks) as remarks"),
						 'mas_cost_centers.description',			
							DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
							DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
						 'trn_journals.ttype',
						  'trn_journals.amount',
						 'customers.customer_name',
		])
		->orderBy('mas_journals.id');
		 $masjournals->where('mas_journals.journaldate','>=',$start_date);
		 $masjournals->where('mas_journals.journaldate','<=',$end_date);
		 $masjournals->where('trn_journals.glcode',$selectedglcodes);

        $masjournals = $masjournals->get();

		$trnjournals = TrnJournal::query()
						->Join('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
			->select([	

						  DB::raw("SUM(IF(trn_journals.ttype='Dr',trn_journals.amount,0)) AS DrCashAmounte"),
						  DB::raw("SUM(IF(trn_journals.ttype='Cr',trn_journals.amount,0)) AS CrCashAmount"),
				]);
					 $trnjournals->where('mas_journals.journaldate','<',$start_date);
					 $trnjournals->where('trn_journals.glcode',100000);

					$trnjournals = $trnjournals->get();
        return view("pages.accounts.generalLedger", compact("menus","start_date","end_date","selectedglcodes","glcodes","masjournals","glcodeName","trnjournals"));
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
		$request->validate([
			'gl_codes' => 'required|gt:0',
			],['gl_codes.gt'=>'Accounts Head is required']);
			
		
		$selectedglcodes=$request->gl_codes;
		$start_date=$request->start_date;
		$end_date=$request->end_date;

		$glcodes = GlCode::orderBy ('description')->get();
		
		$glcodeName="";
		if($request->gl_codes>=1) {
		$glcodeName=pick('gl_codes','description','gl_code="'.$request->gl_codes.'"');
		$glcodeName=$glcodeName[0]->description;
		}

        $menus = Menu::get();

		$masjournals = MasJournal::query()
						->Join('trn_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
        ->select([	
	
						'mas_journals.id',
						  'mas_journals.journalno',
						 'mas_journals.journaltype',
						  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
						  DB::raw("if(trn_journals.remarks='',mas_journals.remarks,trn_journals.remarks) as remarks"),
						 'mas_cost_centers.description',			
							DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
							DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
						 'trn_journals.ttype',
						  'trn_journals.amount',
						  'customers.customer_name',
		])
		->orderBy('mas_journals.id');

		 $masjournals->where('mas_journals.journaldate','>=',$start_date);
		 $masjournals->where('mas_journals.journaldate','<=',$end_date);
		 $masjournals->where('trn_journals.glcode',$selectedglcodes);

        $masjournals = $masjournals->get();
		
		$CheckVal=intval(substr($request->gl_codes,0,1));
		
		if($CheckVal==0 || $CheckVal==1 || $CheckVal==2)
			{
				
				$trnjournals = TrnJournal::query()
						->Join('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
			->select([	

						  DB::raw("SUM(IF(trn_journals.ttype='Dr',trn_journals.amount,0)) AS DrCashAmounte"),
						  DB::raw("SUM(IF(trn_journals.ttype='Cr',trn_journals.amount,0)) AS CrCashAmount"),
				]);
					 $trnjournals->where('mas_journals.journaldate','<',$start_date);
					 $trnjournals->where('trn_journals.glcode',$selectedglcodes);

					$trnjournals = $trnjournals->get();
			}else {
				$trnjournals = TrnJournal::query()
						->Join('mas_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('mas_cost_centers', 'mas_cost_centers.id', '=', 'trn_journals.cost_code')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
			->select([	

						  DB::raw("SUM(IF(trn_journals.ttype='Dr',trn_journals.amount,0)) AS DrCashAmounte"),
						  DB::raw("SUM(IF(trn_journals.ttype='Cr',trn_journals.amount,0)) AS CrCashAmount"),
				]);
					 $trnjournals->where('mas_journals.journaldate','<',$start_date);
					 $trnjournals->where('trn_journals.glcode',100000);

					$trnjournals = $trnjournals->get();
			}

        return view("pages.accounts.generalLedger", compact("menus","start_date","end_date","selectedglcodes","glcodes","masjournals","glcodeName","trnjournals"));
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
