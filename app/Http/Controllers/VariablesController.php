<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Variables;
use Illuminate\Http\Request;

class VariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $variables = Variables::all();
        return view("pages.setup.variables", compact("menus", "variables"));
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
            'variable_name' => 'required|unique:variables,variable_name',
            'status' => 'required'
        ]);
        $zone = Variables::create($data);
        return redirect()->route("variables.index") -> with('success', 'Variables added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Variables $variable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variables $variable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variables $variable)
    {
        //
        $data = $request->validate([
            'variable_name' => 'required',
            'status' => 'required'
        ]);
        $variable->update($data);
        return redirect()->route("variables.index") -> with('success', 'Variables updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variables $variable)
    {
        //
        $dvariable = Variables::find($variable -> id);
        $dvariable->delete();
        return redirect() -> route("variables.index") -> with('success', 'Variables deleted successfully');
    }
}
