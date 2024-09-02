<?php

namespace App\Http\Controllers;

use App\Models\TblZone;
use App\Models\Menu;
use Illuminate\Http\Request;

class TblZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $zones = TblZone::get();
        return view("pages.setup.zone", compact("menus", "zones"));
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
        $data = $request->validate([
            'zone_name' => 'required|unique:tbl_zone,zone_name',
            'status' => 'required'
        ]);
        $zone = TblZone::create($data);
        return redirect()->route("zone.index") -> with('success', 'Zone added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblZone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblZone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblZone $zone)
    {
        //
        $data = $request->validate([
            'zone_name' => 'required',
            'status' => 'required'
        ]);
        $zone->update($data);

        return redirect()->route("zone.index") -> with('success', 'Zone updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblZone $zone)
    {
        //
        $dzone = TblZone::find($zone -> id);
        $dzone->delete();
        return redirect() -> route("zone.index") -> with('success', 'Zone deleted successfully');
    }
}
