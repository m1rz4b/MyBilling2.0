<?php

namespace App\Http\Controllers;

use App\Models\StaticIp;
use App\Models\Menu;
use Illuminate\Http\Request;


class StaticIpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $stat_ips = StaticIp::get();
        return view("pages.radius.staticIp", compact("menus","stat_ips"));
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
            'name' => 'required|string|unique:static_ips,name',
            'range' => 'required|string'
        ]);

        $user_id = 1; //Replace by Auth later

        $StaticIp = StaticIp::create([
            'name' => ($request->name==null) ? '' : $request->name,
            'range' => ($request->range==null) ? '' : $request->range,
            'status' => ($request->status==null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('staticip.index')) -> with('success', 'IP added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(StaticIp $staticIp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaticIp $staticIp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $staticIp)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'name' => 'required|string',
            'range' => 'required|string'
        ]);

        $ip = StaticIp::find($staticIp);
        $ip->name = $request->name;
        $ip->range = $request->range;
        $ip->status = $request->status;
        $ip->updated_by = $user_id;
        $ip->save();
        return redirect(route('staticip.index')) -> with('success', 'IP has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($staticip = null)
    {
        $user_id = 1; //Replace by Auth later

        $ip = StaticIp::find($staticip);
        $ip->deleted_by = $user_id;
        $ip->save();
        $ip->delete();
        return redirect(route('staticip.index')) -> with('success', 'Static IP has been deleted successfully');
    }
}
