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


class JournalController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $selectedglcodes = -1;
		$selectedgl_types="";
		$glcodeName="";
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		$glcodes = GlCode::orderBy ('description')->get();
		
        $menus = Menu::get();

		$masjournals = MasJournal::query()
						->Join('trn_journals', 'mas_journals.id', '=', 'trn_journals.journalid')
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
						->leftJoin('mas_suppliers', 'mas_suppliers.id', '=', 'mas_journals.supplierid')
						->leftJoin('mas_employees', 'mas_employees.id', '=', 'mas_journals.emp_id')
        ->select([	
						'mas_journals.id',
						  'mas_journals.journalno',
						 'mas_journals.journaltype',
						  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
						   'mas_journals.remarks',
							'gl_codes.description',			
							DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
							DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
						 'trn_journals.ttype',
						  'trn_journals.amount',
						  'mas_employees.emp_name as employee',
							'mas_suppliers.clients_name as supplier',  
						  'customers.customer_name as cleint',
		])
		->orderBy('mas_journals.journaldate')
		->orderBy('mas_journals.journalno')
		->orderBy('mas_journals.journaltype');

		 $masjournals->where('mas_journals.journaldate','>=',$start_date);
		 $masjournals->where('mas_journals.journaldate','<=',$end_date);

        $masjournals = $masjournals->get();
		
        return view("pages.accounts.journal", compact("menus","start_date","end_date","selectedglcodes","glcodes","masjournals","glcodeName"));
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
			
		
		$selectedglcodes=$request->gl_codes;
		$selectedgl_types=$request->gl_types;
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
						->leftJoin('gl_codes', 'gl_codes.gl_code', '=', 'trn_journals.glcode')
						->leftJoin('customers', 'customers.id', '=', 'mas_journals.partyid')
						->leftJoin('mas_suppliers', 'mas_suppliers.id', '=', 'mas_journals.supplierid')
						->leftJoin('mas_employees', 'mas_employees.id', '=', 'mas_journals.emp_id')
        ->select([	
						'mas_journals.id',
						  'mas_journals.journalno',
						 'mas_journals.journaltype',
						  DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y')as journaldate"),
						   'mas_journals.remarks',
						 'gl_codes.description',			
							DB::raw("IF(trn_journals.ttype='Dr',trn_journals.amount,0) AS DrAmount"),
							DB::raw("IF(trn_journals.ttype='Cr',trn_journals.amount,0) AS CrAmount"),
						 'trn_journals.ttype',
						  'trn_journals.amount',
						  'mas_employees.emp_name as employee',
							'mas_suppliers.clients_name as supplier',  
						  'customers.customer_name as cleint',
		])
		->orderBy('mas_journals.journaldate')
		->orderBy('mas_journals.journalno')
		->orderBy('mas_journals.journaltype');

		 $masjournals->where('mas_journals.journaldate','>=',$start_date);
		 $masjournals->where('mas_journals.journaldate','<=',$end_date);

		 if($selectedglcodes>=1)
		 {
		 $masjournals->where('trn_journals.glcode',$selectedglcodes);	 
		 }
		 if($selectedgl_types)
		 {
		 $masjournals->where('mas_journals.journaltype',$selectedgl_types);	 
		 }

        $masjournals = $masjournals->get();
		
        return view("pages.accounts.journal", compact("menus","start_date","end_date","selectedglcodes","glcodes","masjournals","glcodeName"));
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
