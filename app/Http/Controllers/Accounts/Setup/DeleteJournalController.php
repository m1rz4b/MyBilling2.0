<?php

namespace App\Http\Controllers\Accounts\Setup;

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
use App\Models\MasJournal;



class DeleteJournalController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

		$selectedvoucher_type="";
	
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");

        $menus = Menu::get();
		
		$journal_lists = MasJournal::query()
						
         ->select([			'mas_journals.id as journalid',
                            'mas_journals.journalno',
							'mas_journals.journaltype',
							DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y') as journaldate"),
					 			
				])
		->orderBy('mas_journals.journaldate' , 'desc')
		->orderBy('mas_journals.journaltype')
		->orderBy('mas_journals.journalno' , 'desc');
 
 		$journal_lists->where('mas_journals.journal_status',0);
		$journal_lists->where('mas_journals.journaldate','>=' ,$start_date);
		$journal_lists->where('mas_journals.journaldate','<=' ,$end_date);

        if ($selectedvoucher_type) {
            $journal_lists->where('mas_journals.journaltype', $selectedvoucher_type);
        }
	
        $journal_lists = $journal_lists->get();

        return view("pages.accounts.setup.deleteJournal", compact("menus", "journal_lists", "selectedvoucher_type","start_date","end_date"));
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
		$sjournalid = $request->journalid;
		
		$selectedvoucher_type = $request->voucher_type;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
	
/*	
		$journal_lists = MasJournal::query()
						
         ->select([			'mas_journals.id as journalid',
                            'mas_journals.journalno',
							'mas_journals.journaltype',
							DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y') as journaldate"),
					 			
				])
		->orderBy('mas_journals.journaldate' , 'desc')
		->orderBy('mas_journals.journaltype')
		->orderBy('mas_journals.journalno' , 'desc');
 
 		$journal_lists->where('mas_journals.journal_status',0);
		$journal_lists->where('mas_journals.journaldate','>=' ,$start_date);
		$journal_lists->where('mas_journals.journaldate','<=' ,$end_date);

        if ($selectedvoucher_type) {
            $journal_lists->where('mas_journals.journaltype', $selectedvoucher_type);
        }
	
        $journal_lists = $journal_lists->get();
		
*/	
	//  dd($sjournalid); 
	  
	try {
    DB::beginTransaction(); // <= Starting the transaction

		$oper1 = "Delete from mas_journals where mas_journals.id='$sjournalid'";
        DB::select($oper1);
		$oper2 = "Delete from mas_journals where mas_journals.id='$sjournalid'";
        DB::select($oper2);
		$oper3 = "Update mas_invoices set journal_id=0,journal_status=0 where journal_id='$sjournalid'";
        DB::select($oper3);
		$oper4 = "Update mas_supplier_invoices set journal_id=0,journal_status=0 where journal_id='$sjournalid'";
        DB::select($oper4);
		$oper5 = "Update mas_collections set journal_id=0 where journal_id='$sjournalid'";
        DB::select($oper5);
		$oper6 = "Update trn_requisition set inv_journal_id=0,journal_status=0 where inv_journal_id='$sjournalid'";
        DB::select($oper6);
		$oper7 = "Update trn_purchase_return set inv_journal_id=0,journal_status=0 where inv_journal_id='$sjournalid'";
        DB::select($oper7);
		$oper8 = "Update trn_asset_disposal set journal_id=0 where journal_id='$sjournalid'";
        DB::select($oper8);
		$oper9 = "Update mas_purchase_returns set journal_id=0,journal_status=0 where journal_id='$sjournalid'";
        DB::select($oper9);
		$oper10 = "Update mas_payments set journalno=0 where journalno='$sjournalid'";
        DB::select($oper10);
		$oper11 = "Update hrm_emp_monthly_salary set jv_status=0,jv_id=0 where jv_id='$sjournalid'";
        DB::select($oper11);
	
    DB::commit(); // <= Commit the changes
	return redirect('/deletejournal')->with('success','Journal Deleted Successfull');
	} catch (\Exception $e) {
    report($e);
    
    DB::rollBack(); // <= Rollback in case of an exception
	return redirect('/deletejournal')->withErrors(['Journal Deleted Failed']);
	}
	
	//	 return view("pages.accounts.setup.deleteJournal", compact("menus", "journal_lists", "selectedvoucher_type","start_date","end_date"));
	
		
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
		
	//	$request->validate([
  //          'voucher_type' => 'required'
  //      ]);
	
		$selectedvoucher_type = $request->voucher_type;
		$start_date = $request->start_date;
		$end_date = $request->end_date;

        $menus = Menu::get();
		
		$journal_lists = MasJournal::query()
						
         ->select([			'mas_journals.id as journalid',
                            'mas_journals.journalno',
							'mas_journals.journaltype',
							DB::raw("date_format(mas_journals.journaldate,'%d-%m-%Y') as journaldate"),
					 			
				])
		->orderBy('mas_journals.journaldate' , 'desc')
		->orderBy('mas_journals.journaltype')
		->orderBy('mas_journals.journalno' , 'desc');
 
 		$journal_lists->where('mas_journals.journal_status',0);
		$journal_lists->where('mas_journals.journaldate','>=' ,$start_date);
		$journal_lists->where('mas_journals.journaldate','<=' ,$end_date);

        if ($selectedvoucher_type) {
            $journal_lists->where('mas_journals.journaltype', $selectedvoucher_type);
        }
	
        $journal_lists = $journal_lists->get();

        return view("pages.accounts.setup.deleteJournal", compact("menus", "journal_lists", "selectedvoucher_type","start_date","end_date"));
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