<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Radgroupreply;
use App\Models\Radgroupcheck;
use App\Models\Nas;
use App\Models\TblClientType;
use App\Models\IpPool;
use Illuminate\Support\Facades\DB;

class AssignPoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ip = [];
        $nas = [];
        $mikrotik_rate_limit = [];
        $framed_pool = [];
        $menus = Menu::get();

        $rad_group_reply = RadGroupReply::leftJoin('radgroupcheck', 'radgroupcheck.groupname', '=', 'radgroupreply.groupname')
            ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'radgroupreply.groupname',)
            ->select('tbl_client_types.name', 'tbl_client_types.id')
            ->groupBy('radgroupreply.groupname', 'tbl_client_types.name', 'tbl_client_types.id')
            ->get();

        foreach ($rad_group_reply as $rad_reply) {
            $client_id = $rad_reply->id;

            $ip = Radgroupcheck::where('groupname', $client_id)
                ->select('value')
                ->first();

            $nas = Nas::where('nasname', $ip->value)
                ->select('shortname')
                ->first();

            $mikrotik_rate_limit = RadGroupReply::select('value')
                ->where('groupname', $client_id)
                ->where('attribute', 'Mikrotik-Rate-Limit')
                ->first();

            $framed_pool = RadGroupReply::select('value')
                ->where('groupname', $client_id)
                ->where('attribute', 'Framed-Pool')
                ->first();
        }

        $packages = TblClientType::select('id', 'name')
            ->orderBy('name')
            ->get();

        $naslist = Nas::select('id', 'shortname')
            ->orderBy('shortname')
            ->get();

        $ip_pools = IpPool::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('pages.radius.assignPool', compact('menus', 'rad_group_reply', 'ip', 'nas', 'mikrotik_rate_limit', 'framed_pool', 'packages', 'naslist', 'ip_pools'));
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
    public function show($assignPool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($assignPool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        if ($request->has('package')) {
            $package_name = $request->package;
            $mikrotik_rate_limit = $request->mikrotik_rate_limit;
            $framed_pool = $request->framed_pool;
            $router_id = $request->router_id;

            Radgroupreply::where('groupname', $id)->delete();

            $isval="( '$package_name', 'Framed-Compression', '==', 'Van-Jacobsen-TCP-IP'),
					( '$package_name', 'Framed-Protocol', '==', 'PPP'),
					( '$package_name', 'Framed-MTU', '==', '1500'),
					( '$package_name', 'Service-Type', '==', 'Framed-User'),
					( '$package_name', 'Mikrotik-Rate-Limit', '==', '$mikrotik_rate_limit'),								
					( '$package_name', 'Port-Limit', '==', '1'),";

            if($framed_pool !=null){
				$isval .= "( '$package_name', 'Framed-Pool', '==', '$framed_pool'),";
			}

            $isval .= "( '$package_name', 'Framed-IP-Netmask', '==', '255.255.255.0');";

            $Usql = DB::select("INSERT INTO `radgroupreply` ( `groupname`, `attribute`, `op`, `value`) VALUES
								$isval");

            RadGroupCheck::where('groupname', $id)->delete();

            if($router_id != 'any' ){
                RadGroupCheck::create([
                    'groupname' => $package_name,
                    'attribute' => 'NAS-IP-Address',
                    'op' => '==',
                    'value' => $router_id
                ]);
            }

            if($Usql)
			{
                return redirect(route('assignpool.index'))->with('success', 'Data successfully updated.');
			} 
			else
			{
                return redirect(route('assignpool.index'))->with('error', 'Failed to update data.');
			}
        } else {
            return redirect(route('assignpool.index'))->with('error', 'Error in updating data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($assignPool)
    {
        //
    }
}
