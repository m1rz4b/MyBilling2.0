<?php

namespace App\Http\Controllers;

use App\Models\IpPool;
use App\Models\Menu;
use App\Models\TblRouter;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;

class IpPoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $ip_pools = IpPool::get();
        $routers = TblRouter::get();
        return view("pages.radius.ipPool", compact("menus", "ip_pools", "routers"));
    }

    public function search(int $search)
    {
        $routerInIppool = TblRouter::find($search);
        
        try {
            $client = new Client([
                'host' => $routerInIppool->router_ip,
                'user' => $routerInIppool->router_username,
                'pass' => $routerInIppool->router_password,
                'port' => $routerInIppool->port,
            ]);

            $query = new Query('/ip/pool/getall');

            $response = $client->query($query)->read();

            if ($response) {
                return response()->json([
                    "status" => true,
                    "msg" => "",
                    "data" => $response
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "msg" => $e->getMessage(),
                "data" => "\nConnection Failed! ".$routerInIppool->router_ip."\nPort: ".$routerInIppool->port."\nUser: ".$routerInIppool->router_username."\nPass: ".$routerInIppool->router_password
            ]);
        }
    }

    public function importRouter(Request $request)
    {
        try {
            $ipPool = IpPool::create([
                'router_id' => $request->routerId ?? '',
                'name' => $request->routerName ?? '',
                'ranges' => $request->routerRanges ?? ''
            ]);

            if ($ipPool) {
                $count = IpPool::count();
                return response()->json([
                    "status" => true,
                    "msg" => "",
                    "data" => $ipPool,
                    "count" => $count
                ]);
            }

        } catch (\Exception $e) {           
            return response()->json([
                "status" => false,
                "msg" => $e->getMessage(),
                "data" => "\nConnection Failed! ".$request->routerId."\nName: ".$request->routerName."\nRanges: ".$request->routerRanges
            ]);
        }
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
    public function show(IpPool $ippool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IpPool $ippool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IpPool $ippool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IpPool $ippool)
    {
        //
        $dippool = IpPool::find($ippool -> id);
        $dippool->delete();
        return redirect() -> route("ippool.index") -> with('success', 'Ip Pool deleted successfully');
    }
}
