<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Radacct;
use App\Models\Nas;
use App\Models\TrnClientsService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccessLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedCustomer = -1;
        $selectedMacAddress = '';
        $selectedIpAddress = '';
        $selectedNas = -1;
        $menus = Menu::where('status',1)->get();
        $nowdate = Carbon::now()->format('Y-m-d');
        $customers = TrnClientsService::select('id', 'user_id')->get();
        $nas = Nas::select('id', 'shortname')->orderBy('shortname')->get();
        $radaccts = Radacct::leftJoin('nas', 'nas.nasname', '=', 'radacct.nasipaddress')
            ->select([
                'radacct.id',
                'radacct.acctsessionid',
                'radacct.acctuniqueid',
                'radacct.username',
                'radacct.groupname',
                'radacct.realm',
                'radacct.nasipaddress',
                'radacct.nasportid',
                'radacct.nasporttype',
                'radacct.acctstarttime',
                'radacct.acctstoptime',
                // DB::raw("DATE_FORMAT(radacct.acctstarttime,'%m/%d/%Y %h:%i:%s') as acctstarttime"),
                // DB::raw("DATE_FORMAT(radacct.acctstoptime,'%m/%d/%Y %h:%i:%s') as acctstoptime"),
                'radacct.acctsessiontime',
                'radacct.acctauthentic',
                'radacct.connectinfo_start',
                'radacct.connectinfo_stop',
                'radacct.acctinputoctets',
                'radacct.acctoutputoctets',
                'radacct.calledstationid',
                'radacct.callingstationid',
                'radacct.acctterminatecause',
                'radacct.servicetype',
                'radacct.framedprotocol',
                'radacct.framedipaddress',
                'radacct.acctstartdelay',
                'radacct.acctstopdelay',
                'radacct.xascendsessionsvrkey',
                'nas.nasname'
            ])
            ->orderBy('radacct.acctstarttime', 'desc')
            ->get();

        return view("pages.radius.accessLog", compact("menus", "radaccts", "nowdate", "customers", "nas", 'selectedCustomer', 'selectedMacAddress', 'selectedIpAddress', 'selectedNas'));
    }

    public function search(Request $request)
    {
        $selectedStartDate = $request->start_date;
        $selectedEndDate = $request->end_date;
        $selectedCustomer = $request->customer;
        $selectedMacAddress = $request->mac_address;
        $selectedIpAddress = $request->ip_address;
        $selectedNas = $request->nas;

        $menus = Menu::where('status',1)->get();
        $nowdate = Carbon::now()->format('Y-m-d');
        $customers = TrnClientsService::select('id', 'user_id')->get();
        $nas = Nas::select('id', 'shortname')->orderBy('shortname')->get();
       
	    $radaccts = Radacct::query()
			->leftJoin('nas', 'nas.nasname', '=', 'radacct.nasipaddress')
            ->select([
                'radacct.id',
                'radacct.acctsessionid',
                'radacct.acctuniqueid',
                'radacct.username',
                'radacct.groupname',
                'radacct.realm',
                'radacct.nasipaddress',
                'radacct.nasportid',
                'radacct.nasporttype',
                'radacct.acctstarttime',
                'radacct.acctstoptime',
                'radacct.acctsessiontime',
                'radacct.acctauthentic',
                'radacct.connectinfo_start',
                'radacct.connectinfo_stop',
                'radacct.acctinputoctets',
                'radacct.acctoutputoctets',
                'radacct.calledstationid',
                'radacct.callingstationid',
                'radacct.acctterminatecause',
                'radacct.servicetype',
                'radacct.framedprotocol',
                'radacct.framedipaddress',
                'radacct.acctstartdelay',
                'radacct.acctstopdelay',
                'radacct.xascendsessionsvrkey',
                'nas.id as nas_id',
                'nas.nasname'
            ])
             ->orderBy('radacct.acctstarttime', 'desc');
		
            if ($selectedStartDate && $selectedEndDate) {
                $start_date = Carbon::parse($request->start_date);
                $end_date = Carbon::parse($request->end_date);      
                $radaccts->where(DB::raw('DATE_FORMAT(acctstarttime,"%Y-%m-%d")'),'>=',$selectedStartDate);
                $radaccts->where(DB::raw('DATE_FORMAT(acctstarttime,"%Y-%m-%d")'),'<=', $selectedEndDate);
            }

            if ($selectedCustomer>-1) {
                $radaccts->where('username', $selectedCustomer);
            }

            if ($selectedMacAddress) {
                $radaccts->where('callingstationid', $selectedMacAddress);
            }

            if ($selectedIpAddress) {
                $radaccts->where('framedipaddress', $selectedIpAddress);
            }

            if ($selectedNas>-1) {
                $radaccts->where('nas.id', $selectedNas);
            }

            $radaccts = $radaccts->get();

            // $radaccts = $radaccts->with('nas')
            //     ->orderBy('acctstarttime', 'desc')
            //     ->paginate(10);

        return view('pages.radius.accessLog', compact('menus', 'nowdate', 'customers', 'nas', 'radaccts', 'selectedCustomer', 'selectedMacAddress', 'selectedIpAddress', 'selectedNas'));
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
    public function show(string $id)
    {
        //
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
