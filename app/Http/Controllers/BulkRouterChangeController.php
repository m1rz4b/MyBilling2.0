<?php

namespace App\Http\Controllers;

use App\Models\BulkRouterChange;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Radcheck;
use App\Models\TblClientCategory;
use App\Models\TblRouter;
use App\Models\TblClientType;
use App\Models\TblStatusType;
use App\Models\TblZone;
use Illuminate\Support\Facades\DB;

class BulkRouterChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $routers = TblRouter::orderBy('router_ip', 'asc')->get();
        $client_types = TblClientType::orderBy('name', 'asc')->get();
        $zones = TblZone::orderBy('zone_name', 'asc')->get();
        $client_categories = TblClientCategory::orderBy('id', 'asc')->get();
        $status_types = TblStatusType::orderBy('inv_name', 'asc')->get();

        return view('pages.radius.bulkRouterChange', compact('menus', 'routers', 'client_types', 'zones', 'client_categories', 'status_types'));
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
        $messages = [
            'required' => 'Please select atleast one :attribute',
        ];
        $data = $request->validate([
            'router' => 'required|not_in:-1',
            'service' => 'required',
            
        ],$messages);

        $selectedIds=$request->service;
        $router = $request->router;

        $router_ip=TblRouter::where('id',$router)->first()->router_ip;

        $servicesSql="SELECT trn_clients_services.id, trn_clients_services.`user_id`, trn_clients_services.`router_id` 
        FROM trn_clients_services 
        Where trn_clients_services.id in (".implode(',',$selectedIds).")";
        $services = DB::select($servicesSql);

        foreach ($services as $service) {
            $hasdata = Radcheck::where('username',$service->user_id)->where('attribute','NAS-IP-Address');
            $asql = "UPDATE trn_clients_services SET router_id = '$router' WHERE id = '$service->id'";

            DB::select($asql);
            if ($hasdata) {
                $rsql = "UPDATE `radcheck` SET `value` = '$router_ip' WHERE `username`='" .$service->user_id ."' AND `attribute`='NAS-IP-Address'";
                DB::select($rsql);
            }
            else{
                $rsql = "INSERT INTO `radcheck` ( `username`, `attribute`, `op`, `value`) VALUES ('" . $service->user_id . "', 'NAS-IP-Address', '==', '" . $router_ip . "')";
                DB::select($rsql);
            }
        }

        return redirect('/bulkrouterchange')->with('success', 'Router Changed Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $messages = [
            'required' => 'Please select atleast one :attribute',
        ];
        $data = $request->validate([
            'router' => 'required|not_in:-1',
        ],$messages);

        $selectedRouter = $request->router;
        $selectedPackage = $request->package;
        $selectedZone = $request->zone;
        $selectedClientType = $request->client_type;
        $selectedStatus = $request->status;

        $menus = Menu::where('status',1)->get();
        $routers = TblRouter::orderBy('router_ip', 'asc')->get();
        $client_types = TblClientType::orderBy('name', 'asc')->get();
        $zones = TblZone::orderBy('zone_name', 'asc')->get();
        $client_categories = TblClientCategory::orderBy('id', 'asc')->get();
        $status_types = TblStatusType::orderBy('inv_name', 'asc')->get();

        $customers = Customer::select(
            'customers.id as customer_id',
            'customers.customer_name',
            'customers.mobile1',
            'customers.account_no',
            'customers.contract_person',
            'trn_clients_services.unit_id',
            'trn_clients_services.tbl_status_type_id',
            'trn_clients_services.ip_number',
            'trn_clients_services.user_id',
            'trn_clients_services.mac_address',
            'trn_clients_services.installation_date',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.id as srv_id',
            'trn_clients_services.block_date',
            'trn_clients_services.tbl_bill_type_id',
            'trn_clients_services.static_ip',
            'tbl_client_types.name as package',
            'tbl_client_categories.name as client_type_name',
            'tbl_bill_types.bill_type_name',
            'tbl_status_types.inv_name',
            'tbl_bandwidth_plans.bandwidth_plan',
            'tbl_routers.router_ip'
        )
        ->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('tbl_client_categories', 'tbl_client_categories.id', '=', 'customers.tbl_client_category_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->leftJoin('tbl_bandwidth_plans', 'tbl_bandwidth_plans.id', '=', 'trn_clients_services.bandwidth_plan_id')
        ->leftJoin('tbl_routers', 'tbl_routers.id', '=', 'trn_clients_services.router_id');

        if ($selectedPackage>-1) {
            $customers->where('tbl_client_types.id',$selectedPackage);
        }
        if ($selectedZone>-1) {
            $customers->where('customers.tbl_zone_id',$selectedZone);
        }
        if ($selectedClientType>-1) {
            $customers->where('customers.tbl_client_category_id',$selectedClientType);
        }
        if ($selectedStatus>-1) {
            $customers->where('trn_clients_services.tbl_status_type_id',$selectedStatus);
        }
        if ($selectedRouter>-1) {
            $customers->where('trn_clients_services.router_id',$selectedRouter);
            $customers = $customers->get();
        }

        return view('pages.radius.bulkRouterChangeData', compact('menus', 'routers', 'client_types', 'zones', 'client_categories', 'status_types','customers','selectedRouter','selectedPackage','selectedZone','selectedClientType','selectedStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BulkRouterChange $bulkRouterChange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BulkRouterChange $bulkRouterChange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BulkRouterChange $bulkRouterChange)
    {
        //
    }
}
