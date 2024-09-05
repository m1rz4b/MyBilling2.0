<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nas;
use App\Models\TblRouter;
use Illuminate\Http\Request;
use App\Providers\RouterOsProvider;
use App\Providers\RouterOsProvider\RouterOsProvider as RouterOsProviderRouterOsProvider;

use \RouterOS\Client;
use \RouterOS\Query;
use Spatie\Ssh\Ssh;

class TblRouterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $routers = TblRouter::get();
        return view("pages.radius.router", compact("menus", "routers"));
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
        $data = $request->validate([
            'router_name' => 'required|unique:tbl_routers,router_name',
            'router_ip' => 'required',
            'router_username' => 'required',
            'router_password' => 'required',
            'router_location' => 'required',
            'local_address' => 'required',
            'ssh_port' => 'required',
            'port' => 'required',
            'dns1' => 'required',
            'lan_interface' => 'required',
            'radius_auth' => 'required',
            'dns2' => 'required',
            'r_secret' => 'required',
            'radius_acct' => 'required',
            'status' => 'required'
        ]);

        $router = TblRouter::create([
            'router_name' => $request->router_name ?? '',
            'router_ip' => $request->router_ip ?? '',
            'router_username' => $request->router_username ?? '',
            'router_password' => $request->router_password ?? '',
            'router_location' => $request->router_location ?? '',
            'local_address' => $request->local_address ?? '',
            'ssh_port' => $request->ssh_port ?? '',
            'port' => $request->port ?? '',
            'dns1' => $request->dns1 ?? '',
            'lan_interface' => $request->lan_interface ?? '',
            'radius_auth' => $request->radius_auth ?? '',
            'dns2' => $request->dns2 ?? '',
            'r_secret' => $request->r_secret ?? '',
            'radius_acct' => $request->radius_acct ?? '',
            'status' => $request->status ?? '',
        ]);

        $routerId = $router->id;

        $nas = Nas::create([
            'nasname' => $request->router_ip ?? '',
            'shortname' => $request->router_name ?? '',
            'type' => 'other',
            'secret' => $request->r_secret ?? '',
            'description' => $request->description ?? '',
            'tbl_router_id' => $routerId,
        ]);

        return redirect() -> route("router.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(TblRouter $router)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblRouter $router)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $router)
    {
        $data = $request->validate([
            'router_name' => 'required',
            'router_ip' => 'required',
            'router_username' => 'required',
            'router_password' => 'required',
            'router_location' => 'required',
            'local_address' => 'required',
            'ssh_port' => 'required',
            'port' => 'required',
            'dns1' => 'required',
            'lan_interface' => 'required',
            'radius_auth' => 'required',
            'dns2' => 'required',
            'r_secret' => 'required',
            'radius_acct' => 'required',
            'status' => 'required'
        ]);

        $router = TblRouter::find($router);
        $router->router_name = $request->router_name;
        $router->router_ip = $request->router_ip;
        $router->router_username = $request->router_username;
        $router->router_password = $request->router_password;
        $router->router_location = $request->router_location;
        $router->local_address = $request->local_address;
        $router->ssh_port = $request->ssh_port;
        $router->port = $request->port;
        $router->dns1 = $request->dns1;
        $router->lan_interface = $request->lan_interface;
        $router->radius_auth = $request->radius_auth;
        $router->dns2 = $request->dns2;
        $router->r_secret = $request->r_secret;
        $router->radius_acct = $request->radius_acct;
        $router -> save();

        $routerId = $router->id;
        $nas = Nas::where('tbl_router_id', $routerId)->first();
        
        $nas->nasname = $request->router_ip;
        $nas->shortname = $request->router_name;
        $nas->secret = $request->r_secret;
        $nas->save();

        return redirect() -> route("router.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblRouter $router)
    {
        //
        $drouter = TblRouter::find($router -> id);
        $drouter->delete();
        return redirect() -> route("router.index");
    }

    public function apiCheckPost(int $router)
    {
        $router = TblRouter::where('id',$router)->first();
        //dd($router);

        

        //dd($router);
        try {
            $client = new Client([
                'host' => $router->router_ip,
                'user' => $router->router_username,
                'pass' => $router->router_password,
                'port' => $router->port,
            ]);

            $query = new Query('/system/clock/print');

            $response = $client->query($query)->read();

            if ($response[0]['time']) {
                return response()->json([
                    "status" => true,
                    "msg" => "",
                    "data" => "Connection Ok! Router Time is ".$response[0]['time']
                ]);
            }
           
        } catch (\Exception $e) {
            //throw $th;
           
                return response()->json([
                    "status" => false,
                    "msg" => $e->getMessage(),
                    "data" => "\nConnection Failed! ".$router->router_ip."\nPort: ".$router->port."\nUser: ".$router->router_username."\nPass: ".$router->router_password
                ]);
            
            
        }
        
        //dd("test");

        

        
        

       

        

        

        // $api = new RouterOsProvider();
        // $api->debug = true;

        // $check = $api->connect($router_ip, $router_user, $router_pass, $router_port);


        // Sending json response to client
        return response()->json([
            "status" => true,
            "data" => $response
        ]);
    }
    public function sshCheckPost(int $router)
    {
        

        $router = TblRouter::where('id',$router)->first();

        
        $process = Ssh::create($router->router_username, $router->router_ip,2020)->execute('ssh -p 2020 user1@192.168.88.1');
        //$process = $process->getOutput();

        

        // $check = $api->connect($router_ip, $router_user, $router_pass, $router_port);

        // Sending json response to client
        return response()->json([
            "status" => true,
            "data" => dump($process)
        ]);
    }
}
