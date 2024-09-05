<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $allmenu = Menu::withoutGlobalScopes()->orderBy('level')->get();
        return view("pages.setup.menu", compact("menus",'allmenu'));
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
            'name' => 'required',
            'pid' => 'required',
            'route' => 'required',
            'level' => 'required',
            'serial' => 'required',
            'is_parent' => 'required',
            'status' => 'required'
        ]);
        //dd($data);
        $menu = Menu::create($data);
        
        return redirect()->route("menu.index") -> with('success', 'Menu added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'pid' => 'required',
            'route' => 'required',
            'level' => 'required',
            'serial' => 'required',
            'is_parent' => 'required',
            'status' => 'required'
        ]);
        $menu->update($data);


        return redirect()->route("menu.index") -> with('success', 'Menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
        $dmenu = Menu::find($menu -> id);
        $dmenu->delete();
        return redirect() -> route("menu.index") -> with('success', 'Menu deleted successfully');
    }
}
