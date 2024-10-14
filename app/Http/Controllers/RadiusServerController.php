<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RadiusServer;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class RadiusServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $radiusServer = RadiusServer::get();
        return view('pages.radius.radiusServer', compact('menus', 'radiusServer'));
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
            'server_ip' => 'required|string',
            'server_name' => 'required|string',
            'auth_api_url' => 'required|string',
            'acct_api_url' => 'required|string'
        ]);

        $user_id = Auth::id();

        RadiusServer::create([
            'server_ip' => ($request->server_ip==null) ? '' : $request->server_ip,
            'server_name' => ($request->server_name==null) ? '' : $request->server_name,
            'auth_api_url' => ($request->auth_api_url==null) ? '' : $request->auth_api_url,
            'acct_api_url' => ($request->acct_api_url==null) ? '' : $request->acct_api_url,
            'status' => ($request->status==null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('radius-server.index')) -> with('success', 'Radius Server added successfully');
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
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();

        $updateData = $request->validate([
            'server_ip' => 'required|string',
            'server_name' => 'required|string',
            'auth_api_url' => 'required|string',
            'acct_api_url' => 'required|string'
        ]);

        $radiusServer = RadiusServer::find($id);
        $radiusServer->server_ip = $request->server_ip;
        $radiusServer->server_name = $request->server_name;
        $radiusServer->auth_api_url = $request->auth_api_url;
        $radiusServer->acct_api_url = $request->acct_api_url;
        $radiusServer->status = $request->status;
        $radiusServer->updated_by = $user_id;
        $radiusServer->save();

        return redirect(route('radius-server.index')) -> with('success', 'Radius Server has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = null)
    {
        $user_id = Auth::id();

        $radiusServer = RadiusServer::find($id);
        $radiusServer->deleted_by = $user_id;
        $radiusServer->save();
        $radiusServer->delete();
        return redirect(route('radius-server.index')) -> with('success', 'Radius Server has been deleted successfully');
    }
}
