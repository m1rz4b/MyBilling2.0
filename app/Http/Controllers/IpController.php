<?php

namespace App\Http\Controllers;

use App\Models\Ip;
use Illuminate\Http\Request;
use App\Models\Menu;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $ips = Ip::get();
        return view('pages.radius.ip', compact('menus', 'ips'));
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
            'package' => 'required|string',
            'ip' => 'required|string|unique:ips,ip'
        ]);

        $user_id = 1; //Replace by Auth later

        $newIp = Ip::create([
            'package' => ($request->package==null) ? '' : $request->package,
            'ip' => ($request->ip==null) ? '' : $request->ip,
            'status' => ($request->status==null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('ip.index')) -> with('success', 'IP added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ip $ip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ip $ip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ip)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'package' => 'required|string',
            'ip' => 'required|string'
        ]);

        $ips = Ip::find($ip);
        $ips->package = $request->package;
        $ips->ip = $request->ip;
        $ips->status = $request->status;
        $ips->updated_by = $user_id;
        $ips->save();

        return redirect(route('ip.index')) -> with('success', 'IP has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ip = null)
    {
        $user_id = 1; //Replace by Auth later

        $ips = Ip::find($ip);
        $ips->deleted_by = $user_id;
        $ips->save();
        $ips->delete();
        return redirect(route('ip.index')) -> with('success', 'IP has been deleted successfully');
    }
}
