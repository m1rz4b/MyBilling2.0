<?php

namespace App\Http\Controllers;

use App\Models\IpPool;
use App\Models\Menu;
use App\Models\TblRouter;
use Illuminate\Http\Request;

class IpPoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $ip_pools = IpPool::get();
        $routers = TblRouter::get();
        return view("pages.radius.ipPool", compact("menus", "ip_pools", "routers"));
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
