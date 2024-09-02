<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MicrotikGraph;
use App\Models\TblRouter;
use Illuminate\Http\Request;

class MicrotikGraphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $mikrotiks = MicrotikGraph::get();
        $routers = TblRouter::get();
        return view("pages.setup.mikrotikGraph", compact("menus", "mikrotiks", "routers"));
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
            'router_id' => 'required',
            'interface' => 'required',
            'allow_address' => 'required',
            'store_on' => 'required',
            'status' => 'required',
        ]);
        // $data = strip_tags($data);

        $mikrotik = MicrotikGraph::create($data);
        return redirect() -> route("mikrotikgraph.index") -> with('success', 'Microtik Graph added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MicrotikGraph $microtikgraph)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MicrotikGraph $microtikgraph)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MicrotikGraph $mikrotikgraph)
    {
        // dd($mikrotik_graph);
        //
        $data = $request->validate([
            'router_id' => 'required',
            'interface' => 'required',
            'allow_address' => 'required',
            'store_on' => 'required',
            'status' => 'required',
        ]);
        // $data = MicrotikGraph::find($mikrotik_graph);
        // $data->router_id = $request->router_id;

        // $data->save();

        // $data = strip_tags($data);

        $mikrotikgraph->update($data);
        return redirect()->route("mikrotikgraph.index") -> with('success', 'Microtik Graph updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MicrotikGraph $microtikgraph)
    {
        //
    }
}
