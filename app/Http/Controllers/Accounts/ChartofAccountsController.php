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


class ChartofAccountsController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $menus = Menu::get();

		$glcodes = GlCode::query()

        ->select([	
						  'gl_codes.gl_code',
						 'gl_codes.description',
						  DB::raw("substr(gl_codes.gl_code,2,4) as l1"),	
							DB::raw("substr(gl_codes.gl_code,4,2) as l2"),

		])
		->orderBy('gl_codes.gl_code');

		 $glcodes->where('gl_codes.gl_code','<>',00000);
        $glcodes = $glcodes->get();
		
        return view("pages.accounts.chartofAccounts", compact("menus","glcodes"));
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
