<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\TblClientType;
use App\Models\TblStatusType;
use App\Models\TblZone;
use App\Models\TrnClientsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TblBillType;
use App\Models\TblBandwidthPlan;

class UserStatusReportController extends Controller
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

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_types = TblClientType::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();

        $countRow = TrnClientsService::query()
            ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
            ->where('trn_clients_services.srv_type_id', 1)
            ->count();

        $today = now(); // Get the current date and time

        $online = TrnClientsService::query()
            ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
            ->leftJoin('radacct as g', function ($join) use ($today) {
                $join->on('g.username', '=', 'trn_clients_services.user_id')
                    ->whereNull('g.acctstoptime');
            })
            ->where('trn_clients_services.srv_type_id', 1)
            ->where('g.acctstarttime', '>=', DB::raw(DB::raw("DATE_FORMAT(DATE_SUB('".$today->format('Y-m-d')."', INTERVAL 1 DAY),'%Y-%m-%d')")))
            ->count('g.id');

        $offline=$countRow-$online;

        $services = TrnClientsService::query()
            ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
            ->leftJoin('tbl_client_categories as b', 'b.id', '=', 'h.tbl_client_category_id')
            ->leftJoin('tbl_bill_types as c', 'c.id', '=', 'trn_clients_services.tbl_bill_type_id')
            ->leftJoin('tbl_status_types as d', 'trn_clients_services.tbl_status_type_id', '=', 'd.id')
            ->leftJoin('tbl_bandwidth_plans as e', 'trn_clients_services.bandwidth_plan_id', '=', 'e.id')
            ->leftJoin('tbl_client_types as f', 'f.id', '=', 'trn_clients_services.tbl_client_type_id')
            ->leftJoin('radacct as g', function ($join) {
                $join->on('g.username', '=', 'trn_clients_services.user_id')
                    ->whereNull('g.acctstoptime');
            })
            ->select([
                'trn_clients_services.tbl_status_type_id',
                'f.name AS package',
                'h.mobile1',
                'trn_clients_services.unit_id',
                'trn_clients_services.user_id',
                'h.account_no',
                'h.present_address',
                DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS installation_date'),
                DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS bill_start_date'),
                'trn_clients_services.block_date',
                'b.name AS client_type_name',
                'c.bill_type_name',
                'e.bandwidth_plan',
                'g.acctstarttime',
                'g.callingstationid',
                'g.framedipaddress',
                'g.acctstoptime',
                'h.customer_name',
                'g.nasipaddress',
                'trn_clients_services.password',
            ])
            ->where('trn_clients_services.srv_type_id', 1)
            ->get();

        return view("pages.radius.userStatusReport", compact("menus", "zones", "client_types", "status_types", "customers", "countRow", "online", "offline", "services", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer"));
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
        $selectedZone = $request->zone;
        $selectedPackage = $request->package;
        $selectedCustomerStatus = $request->customer_status;
        $selectedCurrentStatus = $request->current_status;
        $selectedCustomer = $request->customer;

        $menus = Menu::where('status',1)->get();
        $zones = TblZone::select('id', 'zone_name')->orderBy('zone_name', 'asc')->get();
        $client_types = TblClientType::select('id', 'name')->orderBy('name', 'asc')->get();
        $status_types = TblStatusType::select('id', 'inv_name')->orderBy('inv_name', 'asc')->get();
        $customers = Customer::select('id', 'customer_name')->orderBy('customer_name', 'asc')->get();

        $countRow = TrnClientsService::query()
            ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
            ->where('trn_clients_services.srv_type_id', 1)
            ->count();

        $today = now(); // Get the current date and time

        $online = TrnClientsService::query()
            ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
            ->leftJoin('radacct as g', function ($join) use ($today) {
                $join->on('g.username', '=', 'trn_clients_services.user_id')
                    ->whereNull('g.acctstoptime');
            })
            ->where('trn_clients_services.srv_type_id', 1)
            ->where('g.acctstarttime', '>=', DB::raw(DB::raw("DATE_FORMAT(DATE_SUB('".$today->format('Y-m-d')."', INTERVAL 1 DAY),'%Y-%m-%d')")))
            ->count('g.id');

        $offline=$countRow-$online;

        $services = TrnClientsService::query()
        ->leftJoin('customers as h', 'h.id', '=', 'trn_clients_services.customer_id')
        ->leftJoin('tbl_client_categories as b', 'b.id', '=', 'h.tbl_client_category_id')
        ->leftJoin('tbl_bill_types as c', 'c.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types as d', 'trn_clients_services.tbl_status_type_id', '=', 'd.id')
        ->leftJoin('tbl_bandwidth_plans as e', 'trn_clients_services.bandwidth_plan_id', '=', 'e.id')
        ->leftJoin('tbl_client_types as f', 'f.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('radacct as g', function ($join) {
            $join->on('g.username', '=', 'trn_clients_services.user_id')
                ->whereNull('g.acctstoptime');
        })
        ->select([
            'trn_clients_services.tbl_status_type_id',
            'f.name AS package',
            'h.mobile1',
            'trn_clients_services.unit_id',
            'trn_clients_services.user_id',
            'h.account_no',
            'h.present_address',
            DB::raw('DATE_FORMAT(trn_clients_services.installation_date, "%d/%m/%Y") AS installation_date'),
            DB::raw('DATE_FORMAT(trn_clients_services.bill_start_date, "%d/%m/%Y") AS bill_start_date'),
            'trn_clients_services.block_date',
            'b.name AS client_type_name',
            'c.bill_type_name',
            'e.bandwidth_plan',
            'g.acctstarttime',
            'g.callingstationid',
            'g.framedipaddress',
            'g.acctstoptime',
            'h.customer_name',
            'g.nasipaddress',
            'trn_clients_services.password',
        ])
        ->where('trn_clients_services.srv_type_id', 1);
        
        if ($selectedZone>-1) {
            $services->where('h.tbl_zone_id', $selectedZone);
        }
        if ($selectedPackage>-1) {
            $services->where('f.id',$selectedPackage);
        }
        if ($selectedCustomerStatus>-1) {
            $services->where('trn_clients_services.tbl_status_type_id', $selectedCustomerStatus);
        }
        if ($selectedCurrentStatus>-1) {
            $services->where('g.acctstarttime', '>=', DB::raw(DB::raw("DATE_FORMAT(DATE_SUB('".$today->format('Y-m-d')."', INTERVAL 1 DAY),'%Y-%m-%d')")));
        }
        if ($selectedCustomer>-1) {
            $services->where('trn_clients_services.customer_id',$selectedCustomer);
        }
        $services = $services->get();

        return view("pages.radius.userStatusReport", compact("menus", "zones", "client_types", "status_types", "customers", "countRow", "online", "offline", "services", "selectedZone", "selectedPackage", "selectedCustomerStatus", "selectedCurrentStatus", "selectedCustomer"));
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
