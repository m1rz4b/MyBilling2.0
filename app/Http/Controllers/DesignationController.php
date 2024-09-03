<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Menu;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $designations = Designation::get();
        return view("pages.setup.designation", compact("menus", "designations"));
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
            'designation' => 'required|unique:mas_designation,designation',
            'status' => 'required'
        ]);
        $designation = Designation::create($data);
        return redirect()->route("designation.index") -> with('success', 'Designation added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
        $data = $request->validate([
            'designation' => 'required',
            'status' => 'required'
        ]);
        $designation->update($data);
        return redirect()->route("designation.index") -> with('success', 'Designation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        //
        $ddesignation = Designation::find($designation -> id);
        $ddesignation->delete();
        return redirect() -> route("designation.index") -> with('success', 'Designation deleted successfully');
    }
}
