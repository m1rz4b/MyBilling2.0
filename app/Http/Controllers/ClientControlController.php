<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\ClientControl;
use App\Models\Menu;
use App\Models\Customer;
use App\Models\TrnClientsService;
use App\Models\TblClientType;
use App\Models\TblStatusType;
use App\Models\TblBandwidthPlan;
use App\Models\TblClientCategory;
use App\Models\TblRouter;
use App\Models\TrnClientsServiceRatechange;
use App\Models\TblZone;     //NULL
use App\Models\BlockReason;
use App\Models\StaticIp;
use App\Models\Radcheck;
use App\Models\Radreply;
use App\Models\Radusergroup;
use App\Models\TrnStaticIp;
use App\Models\TrnInvoice;
use App\Models\ChangeRouterLog;
use App\Models\ChangeUseridLog;
use App\Models\ChangePppoeToHotspot;
use App\Models\ChangeHotspotToPppoe;
use App\Models\ChangePassIpMac;
use App\Models\ChangeClientStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\SubZone;  //NULL
use PhpParser\Node\Stmt\Foreach_;

class ClientControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zone = -1;
        $package = -1;
        $status = -1;
        $customer = -1;
        
        $menus = Menu::get();
        $customer_dropdown = Customer::select('customer_name', 'id')->orderBy('customer_name', 'asc')->get();
        $customers = Customer::select(
            'customers.id as customer_id',
            'customers.customer_name',
            'customers.contract_person',
            'customers.mobile1',
            'customers.account_no',
            'customers.tbl_zone_id',
            'trn_clients_services.tbl_status_type_id',
            'trn_clients_services.ip_number',
            'trn_clients_services.unit_id',
            'trn_clients_services.user_id',
            'trn_clients_services.password',
            'trn_clients_services.mac_address',
            'trn_clients_services.installation_date',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.id as srv_id',
            'trn_clients_services.block_date',
            'trn_clients_services.tbl_bill_type_id',
            'trn_clients_services.static_ip',
            'trn_clients_services.block_reason_id',
            'trn_clients_services.rate_amnt',
            'trn_clients_services.tbl_client_type_id',
            'tbl_client_types.name as package',
            'tbl_client_types.price',
            'tbl_client_categories.name as client_type_name',
            'tbl_bill_types.bill_type_name',
            'tbl_status_types.inv_name',
            'tbl_bandwidth_plans.bandwidth_plan',
            'tbl_routers.id as router_id',
            'tbl_routers.router_name',
            'tbl_routers.router_ip'
        )
        ->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('tbl_client_categories', 'tbl_client_categories.id', '=', 'customers.tbl_client_category_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->leftJoin('tbl_bandwidth_plans', 'tbl_bandwidth_plans.id', '=', 'trn_clients_services.bandwidth_plan_id')
        ->leftJoin('tbl_routers', 'tbl_routers.id', '=', 'trn_clients_services.router_id')
        ->get();

        $trn_rate_changes = TrnClientsServiceRatechange::select(
            'trn_clients_service_ratechanges.id',
            'trn_clients_service_ratechanges.customer_id',
            'trn_clients_service_ratechanges.punit',
            'trn_clients_service_ratechanges.punit_qty',
            'trn_clients_service_ratechanges.prate',
            'trn_clients_service_ratechanges.pvat',
            DB::raw("DATE_FORMAT(trn_clients_service_ratechanges.rate_change_date, '%d/%m/%Y') as rate_change_date"),
            'trn_clients_service_ratechanges.cunit',
            'trn_clients_service_ratechanges.cunit_qty',
            'trn_clients_service_ratechanges.crate',
            'trn_clients_service_ratechanges.cvat',
            'customers.customer_name',
            'trn_clients_services.ip_number',
            'tbl_client_types.name as pclienttype',
            't1.name as cclienttype'
        )
        ->leftJoin('customers', 'customers.id', '=', 'trn_clients_service_ratechanges.customer_id')
        ->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'trn_clients_service_ratechanges.trn_clients_service_id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_service_ratechanges.punit')
        ->leftJoin('tbl_client_types AS t1', 't1.id', '=', 'trn_clients_service_ratechanges.cunit')
        ->get();

        $client_types = TblClientType::get();
        $status_types = TblStatusType::orderBy('inv_name', 'asc')->get();
        $zones = TblZone::get();
        $blockreasons = BlockReason::orderBy('block_reason_name', 'asc')->get();
        $staticip = StaticIp::get();
        $routers = TblRouter::get();

        $packages = DB::select("
            SELECT tbl_client_types.id, 
            CONCAT(tbl_client_types.name, ' => Head Office') AS package_name,
            tbl_client_types.price
            FROM tbl_client_types 
            LEFT JOIN customers ON customers.id = tbl_client_types.reseller_id 
            AND customers.reseller_id = 0 
            ORDER BY tbl_client_types.id"
        ); 
        
        $router_logs = ChangeRouterLog::select(
            'previous_router.router_name as previous',
            'current_router.router_name as current',
            'change_router_logs.customer_id',
            'change_router_logs.created_at',
            'users.name as user_name'
        )
            ->leftJoin('tbl_routers as previous_router', 'change_router_logs.previous_router', '=', 'previous_router.id')
            ->leftJoin('tbl_routers as current_router', 'change_router_logs.current_router', '=', 'current_router.id')
            ->leftJoin('users', 'change_router_logs.created_by', '=', 'users.id')->get();

        $userid_logs = ChangeUseridLog::select('change_userid_logs.*', 'users.name')
            ->leftJoin('users', 'change_userid_logs.created_by', '=', 'users.id')
            ->get();

        $pppoe_to_hotspot_logs = ChangePppoeToHotspot::select('change_pppoe_to_hotspots.*', 'users.name as username', 'static_ips.name')
            ->leftJoin('users', 'change_pppoe_to_hotspots.created_by', '=', 'users.id')
            ->leftJoin('static_ips', 'change_pppoe_to_hotspots.static_ip', '=', 'static_ips.id')
            ->get();

        $hotspot_to_pppoe_logs = ChangeHotspotToPppoe::select('change_hotspot_to_pppoes.*', 'users.name as username', 'static_ips.name')
            ->leftJoin('users', 'change_hotspot_to_pppoes.created_by', '=', 'users.id')
            ->leftJoin('static_ips', 'change_hotspot_to_pppoes.static_ip', '=', 'static_ips.id')
            ->get();

        $pass_ip_mac_logs = ChangePassIpMac::select('change_pass_ip_macs.*', 'users.name')
            ->leftJoin('users', 'change_pass_ip_macs.created_by', '=', 'users.id')
            ->get();

        $client_status_logs = ChangeClientStatus::select('change_client_statuses.*', 'users.name', 'block_reasons.block_reason_name')
            ->leftJoin('users', 'change_client_statuses.created_by', '=', 'users.id')
            ->leftJoin('block_reasons', 'change_client_statuses.block_reason', '=', 'block_reasons.id')
            ->get();

        return view(
            'pages.radius.clientControl',
            compact(
                'menus',
                'customer_dropdown',
                'customers',
                'client_types',
                'trn_rate_changes',
                'zones',
                'status_types',
                'blockreasons',
                'staticip',
                'routers',
                'router_logs',
                'packages',
                'userid_logs',
                'pppoe_to_hotspot_logs',
                'hotspot_to_pppoe_logs',
                'pass_ip_mac_logs',
                'client_status_logs',
                'zone',
                'package',
                'status',
                'customer'
            )
        );
    }

    public function search(Request $request)
    {
        $menus = Menu::get();

        $customer_dropdown = Customer::select('customer_name', 'id')->orderBy('customer_name', 'asc')->get();

        $zone = $request->zone;
        $package = $request->package;
        $status = $request->status;
        $customer = $request->customer;

        $customers = Customer::select(
            'customers.id as customer_id',
            'customers.customer_name',
            'customers.contract_person',
            'customers.mobile1',
            'customers.account_no',
            'customers.tbl_zone_id',
            'trn_clients_services.tbl_status_type_id',
            'trn_clients_services.ip_number',
            'trn_clients_services.unit_id',
            'trn_clients_services.user_id',
            'trn_clients_services.password',
            'trn_clients_services.mac_address',
            'trn_clients_services.installation_date',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.id as srv_id',
            'trn_clients_services.block_date',
            'trn_clients_services.tbl_bill_type_id',
            'trn_clients_services.static_ip',
            'trn_clients_services.block_reason_id',
            'trn_clients_services.rate_amnt',
            'trn_clients_services.tbl_client_type_id',
            'tbl_client_types.name as package',
            'tbl_client_types.price',
            'tbl_client_categories.name as client_type_name',
            'tbl_bill_types.bill_type_name',
            'tbl_status_types.inv_name',
            'tbl_bandwidth_plans.bandwidth_plan',
            'tbl_routers.id as router_id',
            'tbl_routers.router_name',
            'tbl_routers.router_ip'
        )
        ->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->leftJoin('tbl_client_categories', 'tbl_client_categories.id', '=', 'customers.tbl_client_category_id')
        ->leftJoin('tbl_bill_types', 'tbl_bill_types.id', '=', 'trn_clients_services.tbl_bill_type_id')
        ->leftJoin('tbl_status_types', 'tbl_status_types.id', '=', 'trn_clients_services.tbl_status_type_id')
        ->leftJoin('tbl_bandwidth_plans', 'tbl_bandwidth_plans.id', '=', 'trn_clients_services.bandwidth_plan_id')
        ->leftJoin('tbl_routers', 'tbl_routers.id', '=', 'trn_clients_services.router_id');

        if ($zone>-1) {
            $customers->where('customers.tbl_zone_id',$zone);
        }
        if ($package>-1) {
            $customers->where('trn_clients_services.tbl_client_type_id',$package);
        }
        if ($status>-1) {
            $customers->where('trn_clients_services.tbl_status_type_id',$status);
        }
        if ($customer>-1) {
            $customers->where('customers.id',$customer);
        }
        $customers = $customers->get();

        
        // ->where(function($query) use ($zone, $package, $status, $customer) {
        //     $query->orWhere('tbl_zone_id', 'like', "%$zone%")
        //         ->orWhere('trn_clients_services.tbl_client_type_id', '=', $package)
        //         ->orWhere('trn_clients_services.tbl_status_type_id', '=', $status)
        //         ->orWhere('customer_name', 'like', "%$customer%");
        // })
        // ->get();

        $packages = DB::select("
            SELECT tbl_client_types.id, 
            CONCAT(tbl_client_types.name, ' => Head Office') AS package_name,
            tbl_client_types.price
            FROM tbl_client_types 
            LEFT JOIN customers ON customers.id = tbl_client_types.reseller_id 
            AND customers.reseller_id = 0 
            ORDER BY tbl_client_types.id"
        ); 

        $trn_rate_changes = TrnClientsServiceRatechange::select(
            'trn_clients_service_ratechanges.id',
            'trn_clients_service_ratechanges.customer_id',
            'trn_clients_service_ratechanges.punit',
            'trn_clients_service_ratechanges.punit_qty',
            'trn_clients_service_ratechanges.prate',
            'trn_clients_service_ratechanges.pvat',
            DB::raw("DATE_FORMAT(trn_clients_service_ratechanges.rate_change_date, '%d/%m/%Y') as rate_change_date"),
            'trn_clients_service_ratechanges.cunit',
            'trn_clients_service_ratechanges.cunit_qty',
            'trn_clients_service_ratechanges.crate',
            'trn_clients_service_ratechanges.cvat',
            'customers.customer_name',
            'trn_clients_services.ip_number',
            'tbl_client_types.name as pclienttype',
            't1.name as cclienttype'
        )
        ->leftJoin('customers', 'customers.id', '=', 'trn_clients_service_ratechanges.customer_id')
        ->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'trn_clients_service_ratechanges.trn_clients_service_id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_service_ratechanges.punit')
        ->leftJoin('tbl_client_types AS t1', 't1.id', '=', 'trn_clients_service_ratechanges.cunit')
        ->get();

        $client_types = TblClientType::get();
        $status_types = TblStatusType::orderBy('inv_name', 'asc')->get();
        $zones = TblZone::get();
        $blockreasons = BlockReason::orderBy('block_reason_name', 'asc')->get();
        $staticip = StaticIp::get();
        $routers = TblRouter::get();

        $router_logs = ChangeRouterLog::select(
            'previous_router.router_name as previous',
            'current_router.router_name as current',
            'change_router_logs.customer_id',
            'change_router_logs.created_at',
            'users.name as user_name'
        )
            ->leftJoin('tbl_routers as previous_router', 'change_router_logs.previous_router', '=', 'previous_router.id')
            ->leftJoin('tbl_routers as current_router', 'change_router_logs.current_router', '=', 'current_router.id')
            ->leftJoin('users', 'change_router_logs.created_by', '=', 'users.id')->get();

        $userid_logs = ChangeUseridLog::select('change_userid_logs.*', 'users.name')
            ->leftJoin('users', 'change_userid_logs.created_by', '=', 'users.id')
            ->get();

        $pppoe_to_hotspot_logs = ChangePppoeToHotspot::select('change_pppoe_to_hotspots.*', 'users.name as username', 'static_ips.name')
            ->leftJoin('users', 'change_pppoe_to_hotspots.created_by', '=', 'users.id')
            ->leftJoin('static_ips', 'change_pppoe_to_hotspots.static_ip', '=', 'static_ips.id')
            ->get();

        $hotspot_to_pppoe_logs = ChangeHotspotToPppoe::select('change_hotspot_to_pppoes.*', 'users.name as username', 'static_ips.name')
            ->leftJoin('users', 'change_hotspot_to_pppoes.created_by', '=', 'users.id')
            ->leftJoin('static_ips', 'change_hotspot_to_pppoes.static_ip', '=', 'static_ips.id')
            ->get();

        $pass_ip_mac_logs = ChangePassIpMac::select('change_pass_ip_macs.*', 'users.name')
            ->leftJoin('users', 'change_pass_ip_macs.created_by', '=', 'users.id')
            ->get();

        $client_status_logs = ChangeClientStatus::select('change_client_statuses.*', 'users.name', 'block_reasons.block_reason_name')
            ->leftJoin('users', 'change_client_statuses.created_by', '=', 'users.id')
            ->leftJoin('block_reasons', 'change_client_statuses.block_reason', '=', 'block_reasons.id')
            ->get();

        return view(
            'pages.radius.clientControl',
            compact(
                'menus',
                'request',
                'packages',
                'customer_dropdown',
                'customers',
                'trn_rate_changes',
                'zones',
                'client_types',
                'status_types',
                'blockreasons',
                'staticip',
                'routers',
                'router_logs',
                'userid_logs',
                'pppoe_to_hotspot_logs',
                'hotspot_to_pppoe_logs',
                'pass_ip_mac_logs',
                'client_status_logs',
                'zone',
                'package',
                'status',
                'customer'
            )
        );
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
        // dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientControl $clientControl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientControl $clientControl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $trn_client_service_id)
    {
        //
    }

    public function blockOrActive(Request $request, $trn_client_service_id)
    {
        $request->validate([
            'client_status' => 'string',
            'exp_date' => 'string',
            'reason' => 'string',
        ]);

        $user_id = $request->user_id;
        $block_date = $request->exp_date;
        $date_exp = date('d M Y', strtotime($block_date));

        Radcheck::where('username', $user_id)
            ->where('attribute', 'Expiration')
            ->update(['value' => $date_exp]);
        
        $client_services = TrnClientsService::find($trn_client_service_id);

        $previous_status = $client_services->tbl_status_type_id;

        $client_services->tbl_status_type_id = $request->client_status;
        $client_services->block_date = $request->exp_date;
        $client_services->block_reason_id = $request->reason;
        $authid = Auth::id();

        ChangeClientStatus::create([
            'customer_id' => $client_services->customer_id,
            'block_reason' => ($request->reason == null) ? '' : $request->reason,
            'exp_date' => ($request->exp_date == null) ? '' : $request->exp_date,
            'previous_status' => $previous_status,
            'current_status' => ($request->client_status == null) ? '' : $request->client_status,
            'created_by' => $authid
        ]);


        $client_services->save();

        return redirect(route('clientcontrol.index'))->with('success', 'Client Status has been updated successfully');
    }

    public function changePackage(Request $request, $trn_client_service_id)
    {
        $updateData = $request->validate([
            'package' => 'string',
            'package_rate' => 'string'
        ]);


        $SUserID = Auth::id();
        $reseller_id = 0;
        $cshare_rate = 0;
        $share_rate = 0;
        $customer_id = TrnClientsService::select('customer_id')->where('id',$trn_client_service_id)->first()->customer_id;
        //dd($customer_id);
        //taking current date as change date
        $rate_change_date=date('d/m/Y');
        $piece2 = explode("/", $rate_change_date);
        //changing format
        $rate_change_date = $piece2[2]."-".$piece2[1]."-".$piece2[0];
        $cmonth=$piece2[1]; //getting current month
        $cyear=$piece2[2]; //getting current year
        $last_day=cal_days_in_month(CAL_GREGORIAN, $piece2[1], $piece2[2]); //geting last day of the month
        $last_date = $piece2[2]."-".$piece2[1]."-".$last_day; //creating last day of the month

        $date1 = Carbon::parse($rate_change_date);
        $date2 = Carbon::parse($last_date);
        $tdays  = $date2->diff($date1)->format('%a')+1; //finding day count from change date to last day of month

    


        //update trn_invoice (If exist changes for this month) table start
        $maxrec = TrnInvoice::whereYear('change_date', $cyear)
            ->whereMonth('change_date', $cmonth)
            ->where('serv_id', $trn_client_service_id)
            ->where('c_type', 'Rate Change')
            ->max('id');

        if ($maxrec > 0) {
            $SeNTlist = TrnInvoice::where('id', $maxrec)->first();
            //dd($SeNTlist);

            $pshare_rate = TblClientType::where('unit', $request->package_change)->value('share_rate');

            $cshare_rate = TblClientType::where('unit', $request->current_package)->value('share_rate');

            $date1 = Carbon::parse($SeNTlist->from_date);
            $date2 = Carbon::parse($rate_change_date);
            $totdays  = $date2->diff($date1)->format('%a')+1; //finding day count from change date to last day of month

            $prowamnt = round(($SeNTlist->prate/$last_day)*$totdays);
            $prowvat = round(($SeNTlist->pvate/$last_day)*$totdays);
            $prowtotal= $prowamnt+$prowvat;
            $share_rate = $SeNTlist->share_rate;
            $pshare=round(($SeNTlist->share_rate/$last_day)*$totdays);
		
            $crate= round(($cshare_rate/$last_day)*$totdays);
            
            $crowamnt = round(($SeNTlist->rate/$last_day)*$totdays);
            $crowvat = round(($SeNTlist->vat/$last_day)*$totdays);
            $crowtotal= $crowamnt+$crowvat;
            
            $crowextrabill=$crowtotal-$prowtotal;
            
            $extra_share_rate=$crate-$pshare;

            TrnInvoice::where('id', $maxrec)->update([
                'to_date' => $rate_change_date,
                'camnt' => $crowamnt,
                'cvat' => $crowvat,
                'total' => $crowtotal,
                'extra_bill' => $crowextrabill,
                'share_rate' => $pshare,
                'billingdays' => $totdays,
                'extra_share_rate' => $extra_share_rate
            ]);
        }
        //update trn_invoice (If exist changes for this month) table END

        //update trn_clients_service table START
        
        $vateRate= (float)DB::select("SELECT vat_per FROM tbl_company WHERE id = 1");
        $crates = $request->package_rate;
        
        $cvats=round($crates*$vateRate/(100+$vateRate));
            
        $crate=$crates-$cvats;
        
        $cunit = $request->package_change;		
        $cunit_qty=0; //$_REQUEST['unit_qty'];	
        $punit_qty=0; //$_REQUEST['unit_qty'];	
        $SeNTlist2 = DB::select("
            SELECT 
                trn_clients_services.tbl_client_type_id,                    
                trn_clients_services.rate_amnt,
                trn_clients_services.user_id,
                trn_clients_services.vat_amnt,
                trn_clients_services.unit_qty,
                trn_clients_services.tbl_client_type_id as unit,
                trn_clients_services.customer_id,
                trn_clients_services.id, 
                tbl_client_types.share_rate,
                customers.reseller_id,
                tbl_client_types.share_rate as srate
            FROM
                trn_clients_services
            LEFT JOIN customers ON customers.id = trn_clients_services.customer_id
            LEFT JOIN tbl_client_types ON tbl_client_types.id = trn_clients_services.tbl_client_type_id
            WHERE
                trn_clients_services.id = ".$trn_client_service_id); 
        
        //$cshare = round(($share_rate/$curentmonthday)*$cday*1);

        foreach ($SeNTlist2 as $rowNewsTl) {
            //dd($rowNewsTl);
            $cshare= round(($rowNewsTl->srate/$last_day)*$tdays);	
            $punit = $rowNewsTl->tbl_client_type_id;
            // $punit_qty = $unit_qty;
            $prate = $rowNewsTl->rate_amnt;
            $pvat = $rowNewsTl->vat_amnt;
            $reseller_id = $rowNewsTl->reseller_id;

        }

        TrnClientsService::where('id', $trn_client_service_id)->update([
            'tbl_client_type_id' => $cunit,
            'rate_amnt' => $crate,
            'vat_amnt'  => $cvats,
            'vat_rate'  => $vateRate          
        ]);
      //update trn_clients_service table END


      ///insert rate in trn_invoice START

        $camnt = round(($crate/$last_day)*$tdays);
        $cvat = round(($cvats/$last_day)*$tdays);
        $total= $camnt+$cvat;
        if($maxrec>0){
            $p_amnt = round(($prate/$last_day)*$tdays);
            $p_vat = round(($pvat/$last_day)*$tdays);
            $p_total= $p_amnt+$p_vat;
        }else{
            $p_total=0;
        }
            
        $extra_bill=$total - $p_total;
        
        $p_srate = round(($cshare_rate/$last_day)*$tdays);

       
        if($prate != $crate){
		
            $extra_share_rate=$share_rate-$p_srate;
            
             $sql = "INSERT INTO 
                        trn_invoices (
                        client_id,
                        entry_by,
                        entry_date,
                        serv_id,				
                        from_date,
                        to_date,
                        billingdays,
                        camnt,
                        cvat,
                        total,
                        extra_bill,				
                        unit,
                        unitqty,
                        rate,
                        vat,				
                        change_date,
                        punit,
                        punitqty,
                        prate,
                        pvate,
                        c_type,
                        share_rate,
                        reseller_id,
                        extra_share_rate,
                        billing_year,
                        billing_month
                        ) 
                    VALUES (
                        $customer_id,
                        '$SUserID',
                        NOW(),
                        '$trn_client_service_id',				
                        '$rate_change_date',
                        '$last_date',
                        '$tdays',
                        '$camnt',
                        '$cvat',
                        '$total',
                        '$extra_bill',			
                        '$cunit',
                        '$cunit_qty',
                        '$crate',
                        '$cvats',				
                        '$rate_change_date',
                        '$punit',
                        '$punit_qty',
                        '$prate',
                        '$pvat',				
                        'Rate Change',
                        '$cshare',
                        '$reseller_id',
                        '$extra_share_rate',
                        '$cyear',
                        '$cmonth'
                        )";
            // dd($sql);
               DB::insert($sql);
            
            
        }

        // TrnClientsServiceRatechange::create([
        //     'customer_id' => $customer_id,
        //     'punit' => $punit,
        //     'prate' => $prate,
        //     'pvat' => $pvat,
        //     'rate_change_date' => $rate_change_date,
        //     'cunit' => $cunit,
        //     'crate' => $crate,
        //     'cvat' => $cvats,
        //     'entry_by' => $SUserID,
        //     'entry_date' => now(), // Laravel helper for the current time
        //     'service_id' => $trn_client_service_id,
        // ]);

        DB::insert("
            INSERT INTO trn_clients_service_ratechanges (
                customer_id, 
                punit, 
                prate, 
                pvat,
                rate_change_date, 
                cunit, 
                crate,
                cvat,
                created_by,
                created_at,
                trn_clients_service_id
            ) 
            VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?
            )", [
            $customer_id, $punit, $prate, $pvat, $rate_change_date, 
            $cunit, $crate, $cvats, $SUserID, $trn_client_service_id
        ]);

        $user_id= TrnClientsService::select('user_id')->where('id',$trn_client_service_id)->first();
        $package= TblClientType::select('id')->where('id',$request->package_change)->first();

        DB::update("
            UPDATE radusergroup 
            SET groupname = ?
            WHERE username = ?
        ", [$package, $user_id]);

        return redirect(route('clientcontrol.index'))->with('success', 'Changed Package successfully');


    }

    public function changeIpPassMac(Request $request, $trn_client_service_id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'password' => 'string',
                'mac_address' => 'string',
                'ip_number' => 'string',
            ]);

            $authid = Auth::id();

            $client_services = TrnClientsService::find($trn_client_service_id);
            
            $old_password = $client_services->password;
            $old_ip_number = $client_services->ip_number;
            $old_mac_address = $client_services->mac_address;

            $client_services->password = $request->password;
            $client_services->ip_number = $request->ip_number;
            $client_services->mac_address = $request->mac_address;
            $client_services->save();

            $password = $request->password;
            $mac_address = $request->mac_address;
            $ip_number = $request->ip_number;
            $user_id = $client_services->user_id;

            if ($password != NULL) {
                Radcheck::where('username', $user_id)
                    ->where('attribute', 'User-Password')
                    ->update(['value' => $password]);
            }

            if ($mac_address != NULL) {
                $hasmac = Radcheck::where('username', $user_id)
                    ->where('attribute', 'Calling-Station-Id')
                    ->count();
                if ($hasmac > 0) {
                    Radcheck::where('username', $user_id)
                        ->where('attribute', 'Calling-Station-Id')
                        ->update(['value' => $mac_address]);
                } else {
                    Radcheck::where('username', $user_id)
                        ->where('attribute', 'Calling-Station-Id')
                        ->update(['value' => $mac_address]);
                    Radcheck::insert([
                        'username' => $user_id,
                        'attribute' => 'Calling-Station-Id',
                        'op' => '==',
                        'value' => $mac_address
                    ]);
                }
            } else {
                Radcheck::where('username', $user_id)
                    ->where('attribute', 'Calling-Station-Id')
                    ->delete();
            }

            if ($ip_number != NULL) {
                $hasip = Radreply::where('username', $user_id)
                    ->where('attribute', 'Framed-IP-Address')
                    ->count();

                if ($hasip > 0) {
                    Radreply::where('username', $user_id)
                        ->where('attribute', 'Framed-IP-Address')
                        ->update(['value' => $ip_number]);
                } else {
                    Radreply::insert([
                        'username' => $user_id,
                        'attribute' => 'Framed-IP-Address',
                        'op' => '==',
                        'value' => $ip_number
                    ]);
                }
            } else {
                Radreply::where('username', $user_id)
                    ->where('attribute', 'Framed-IP-Address')
                    ->delete();
            }

            ChangePassIpMac::create([
                'customer_id' => $client_services->customer_id,
                'previous_pass' => $old_password,
                'current_pass' => ($request->password == null) ? '' : $request->password,
                'previous_ip' => $old_ip_number,
                'current_ip' => ($request->ip_number == null) ? '' : $request->ip_number,
                'previous_mac' => $old_mac_address,
                'current_mac' => ($request->mac_address == null) ? '' : $request->mac_address,
                'created_by' => $authid
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect(route('clientcontrol.index'))->with('success', 'Changed Pass/IP/Mac successfully');
    }

    public function pppoeToHotspot(Request $request, $trn_client_service_id)
    {
        // try {
        //     DB::beginTransaction();
            $request->validate([
                'static_ip' => 'string',
                'ip_number' => 'string',
            ]);

            $service = TrnClientsService::with('Customer')->where('id', $trn_client_service_id)->first();

            $old_ip_number = $service->ip_number;
          
            $authid = Auth::id();

            $bandwidthPlan = $service->bandwidth_plan_id;

            if ($bandwidthPlan == 2) {
                $customer_id = $service->customer_id;
                $ac_no = $service->account_no;
                $user_id = $service->user_id;
                $password = $service->password;
                $ip_number = $service->ip_number;
                $mac_address = $service->mac_address;
                $exp_date = $service->block_date;

                TrnClientsService::where('id', $trn_client_service_id)->update([
                    'ip_number' => $request->ip_number,
                    'static_ip' => $request->static_ip
                ]);

                TrnStaticIp::where('ip', $ip_number)->update([
                    'status' => 0
                ]);

                Radcheck::where('username', $user_id)->delete();
                Radreply::where('username', $user_id)->delete();
                Radusergroup::where('username', $user_id)->delete();

                $clientType = TrnClientsService::where('customer_id', $customer_id)
                    ->value('tbl_client_type_id');

                $date_exp = date('d M Y', strtotime($exp_date));

                if (isset($customer_id)) {
                    Radcheck::insert([
                        [
                            'username' => $user_id,
                            'attribute' => 'User-Password',
                            'op' => ':=',
                            'value' => $password
                        ],
                        [
                            'username' => $user_id,
                            'attribute' => 'Expiration',
                            'op' => '==',
                            'value' => $date_exp
                        ],
                        [
                            'username' => $user_id,
                            'attribute' => 'Simultaneous-Use',
                            'op' => ':=',
                            'value' => '1'
                        ]
                    ]);

                    Radusergroup::insert([
                        'username' => $user_id,
                        'groupname' => $clientType,
                        'priority' => '1'
                    ]);

                    if ($mac_address != NULL) {
                        Radcheck::insert([
                            'username' => $user_id,
                            'attribute' => 'Calling-Station-Id',
                            'op' => '==',
                            'value' => $mac_address
                        ]);
                    }

                    if ($ip_number != NULL) {
                        Radcheck::insert([
                            'username' => $user_id,
                            'attribute' => 'Framed-IP-Address',
                            'op' => '==',
                            'value' => $ip_number
                        ]);
                    }
                }
            }

            ChangePppoeToHotspot::create([
                'customer_id' => $service->customer_id,
                'previous_ip' => $old_ip_number,
                'current_ip' => $request->ip_number,
                'static_ip' => $request->static_ip,
                'created_by' => $authid
            ]);

        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }

        return redirect(route('clientcontrol.index'))->with('success', 'PPPOE to Hotspot updated successfully');
    }

    public function hotspotToPPPOE(Request $request, $trn_client_service_id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'static_ip' => 'string',
                'ip_number' => 'string',
            ]);

            $service = TrnClientsService::with('Customer')->where('id', $trn_client_service_id)->first();

            $old_ip_number = $service->ip_number;
          
            $authid = Auth::id();

            $bandwidthPlan = $service->bandwidth_plan_id;

            if ($bandwidthPlan == 2) {
                $customer_id = $service->customer_id;
                $ac_no = $service->account_no;
                $user_id = $service->user_id;
                $password = $service->password;
                $ip_number = $service->ip_number;
                $mac_address = $service->mac_address;
                $exp_date = $service->block_date;

                TrnClientsService::where('id', $trn_client_service_id)->update([
                    'ip_number' => '',
                    'static_ip' => 0
                ]);

                TrnStaticIp::where('ip', $ip_number)->update([
                    'status' => 0
                ]);

                Radcheck::where('username', $user_id)->delete();
                Radreply::where('username', $user_id)->delete();
                Radusergroup::where('username', $user_id)->delete();

                $clientType = TrnClientsService::where('customer_id', $customer_id)
                    ->value('tbl_client_type_id');

                $date_exp = date('d M Y', strtotime($exp_date));

                if (isset($customer_id)) {
                    Radcheck::insert([
                        [
                            'username' => $user_id,
                            'attribute' => 'User-Password',
                            'op' => ':=',
                            'value' => $password
                        ],
                        [
                            'username' => $user_id,
                            'attribute' => 'Expiration',
                            'op' => '==',
                            'value' => $date_exp
                        ],
                        [
                            'username' => $user_id,
                            'attribute' => 'Simultaneous-Use',
                            'op' => ':=',
                            'value' => '1'
                        ]
                    ]);

                    Radusergroup::insert([
                        'username' => $user_id,
                        'groupname' => $clientType,
                        'priority' => '1'
                    ]);

                    if ($mac_address != NULL) {
                        Radcheck::insert([
                            'username' => $user_id,
                            'attribute' => 'Calling-Station-Id',
                            'op' => '==',
                            'value' => $mac_address
                        ]);
                    }
                }
            }

            ChangeHotspotToPppoe::create([
                'customer_id' => $service->customer_id,
                'previous_ip' => $old_ip_number,
                'current_ip' => '',
                'static_ip' => 0,
                'created_by' => $authid
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect(route('clientcontrol.index'))->with('success', 'Hotspot to PPPOE updated successfully');
    }

    public function updateUserid(Request $request, $trn_client_service_id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'client_id' => 'string',
            ]);

            //$customer = Customer::find($trn_client_service_id);
            $service = TrnClientsService::find($trn_client_service_id);
            //dd($service);
            //$radcheck = Radcheck::where('username',$service->user_id)->first();
            //$radreply = Radreply::where('username',$service->user_id)->first();
            //$radusergroup = Radusergroup::where('username',$service->user_id)->first();
            $authid = Auth::id();

            ChangeUseridLog::create([
                'customer_id' => $service->customer_id,
                'previous_id' => $service->user_id,
                'current_id' => ($request->client_id == null) ? '' : $request->client_id,
                'created_by' => $authid
            ]);

            Radcheck::where('username',$service->user_id)->update([
                'username' => $request->client_id
            ]);

            Radreply::where('username',$service->user_id)->update([
                'username' => $request->client_id
            ]);

            radusergroup::where('username',$service->user_id)->update([
                'username' => $request->client_id
            ]);


            $service->user_id = $request->client_id;
            //$radcheck->username = $request->client_id;
            //$radreply->username = $request->client_id;
            //$radusergroup->username = $request->client_id;

            $service->save();
            Schema::disableForeignKeyConstraints();
            //$radcheck->save();
            //$radreply->save();
            //$radusergroup->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect(route('clientcontrol.index'))->with('success', 'User ID has been updated successfully');
    }

    public function updateRouter(Request $request, $trn_client_service_id)
    {
        // try {
        //     DB::beginTransaction();
            $request->validate([
                'new_router' => 'string',
            ]);

            //$customer = Customer::find($trn_client_service_id);
            $service = TrnClientsService::find($trn_client_service_id);
            $authid = Auth::id();

            ChangeRouterLog::create([
                'customer_id' => $service->customer_id,
                'previous_router' => $service->router_id,
                'current_router' => ($request->new_router == null) ? '' : $request->new_router,
                'created_by' => $authid
            ]);

            $service->router_id = $request->new_router;
            $service->save();

           // DB::commit();

        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $th->getMessage();
        // }

        return redirect(route('clientcontrol.index'))->with('success', 'Client Router has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientControl $clientControl)
    {
        //
    }
}
