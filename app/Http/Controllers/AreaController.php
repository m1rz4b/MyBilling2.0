<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Menu;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $areas = Area::get();
        return view("pages.setup.area", compact("menus", "areas"));
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
            'area_name' => 'required|unique:areas,area_name',
            'status' => 'required'
        ]);
        $area = Area::create($data);
        return redirect()->route("area.index") -> with('success', 'Area added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        //
        $data = $request->validate([
            'area_name' => 'required',
            'status' => 'required'
        ]);
        $area->update($data);
        return redirect()->route("area.index") -> with('success', 'Area updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
        $darea = Area::find($area -> id);
        $darea->delete();
        return redirect() -> route("area.index") -> with('success', 'Area deleted successfully');
    }
}
