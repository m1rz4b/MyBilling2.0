<?php

namespace App\Http\Controllers;

use App\Models\MasEmployee;
use App\Models\Menu;
use App\Models\TblScheduleTeam;
use App\Models\TblShiftTeam;
use Illuminate\Http\Request;

class TblShiftTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $shiftTeams = TblShiftTeam::get();
        $scheduleteams = TblScheduleTeam::get();
        $employees = MasEmployee::get();
        return view('pages.hrm.shiftTeam', compact('menus', 'shiftTeams', 'scheduleteams', 'employees'));
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
            'team_id' => 'required',
            'level' => 'required',
            'emp_id' => 'required',
            'status' => 'required'
        ]);

        $shiftteamss = TblShiftTeam::create($data);
        return redirect()->route('shiftteam.index')->with('success', 'Shift Team created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblShiftTeam $tblShiftTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblShiftTeam $tblShiftTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblShiftTeam $shiftteam)
    {
        $data = $request->validate([
            'team_id' => 'required',
            'level' => 'required',
            'emp_id' => 'required',
            'status' => 'required'
        ]);

        $shiftteam->update($data);
        return redirect()->route('shiftteam.index')->with('success', 'Shift Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblShiftTeam $tblShiftTeam)
    {
        //
    }
}
