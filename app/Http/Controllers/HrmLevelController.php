<?php

namespace App\Http\Controllers;

use App\Models\HrmLevel;
use App\Models\Menu;
use Illuminate\Http\Request;

class HrmLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $hrmlevels = HrmLevel::get();
        return view('pages.hrm.level', compact('menus', 'hrmlevels'));
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
            'level_name'=>'required',
            'status'=>'required'
        ]);

        $hrmlevel = HrmLevel::create($data);
        return redirect()->route('hrmlevel.index') -> with('success', 'Level created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrmLevel $hrmLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmLevel $hrmLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmLevel $hrmlevel)
    {
        $data = $request->validate([
            'level_name'=>'required',
            'status'=>'required'
        ]);

        $hrmlevel->update($data);
        return redirect()->route('hrmlevel.index') -> with('success', 'Level updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hrmLevel = null)
    {
        $user_id = 1; //Replace by Auth later

        $hrmLevel = HrmLevel::find($hrmLevel);
        $hrmLevel->deleted_by = $user_id;
        $hrmLevel->save();
        $hrmLevel->delete();
        return redirect(route('hrmlevel.index'))->with('success', 'HRM Level has been deleted successfully');
    }
}
