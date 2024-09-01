<?php

namespace App\Http\Controllers;

use App\Models\HrmShiftSetup;
use App\Models\HrmTblShift;
use App\Models\Menu;
use App\Models\TblScheduleTeam;
use App\Models\TblShiftTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrmShiftSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        // $shiftSetups = HrmShiftSetup::with('TblScheduleTeam', 'HrmTblShift', 'TblShiftTeam')->get();
        $shiftSetups = DB::table('hrm_shift_setup')
                        ->select('hrm_shift_setup.id', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'hrm_tbl_shift.shift_name', 'tbl_schedule_team.team_name', 'tbl_shift_team.level', 'hrm_shift_setup.status')
                        ->leftJoin('hrm_tbl_shift', 'hrm_tbl_shift.id', '=', 'hrm_shift_setup.shift_id')
                        ->leftJoin('tbl_schedule_team', 'tbl_schedule_team.id', '=', 'hrm_shift_setup.team_id')
                        ->leftJoin('tbl_shift_team', 'tbl_shift_team.id', '=', 'hrm_shift_setup.shift_team_id')
                        ->get();
        $shifts = HrmTblShift::get();
        $scheduleteams = TblScheduleTeam::get();
        $shiftteams = TblShiftTeam::get();
        return view('pages.hrm.shiftSetup', compact('menus', 'shiftSetups', 'shifts', 'scheduleteams', 'shiftteams'));
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
            'shift_id' => 'required',
            'shift_team_id' => 'required',
            'status' => 'required'
        ]);

        $data['sun'] = $request->has('sun') ? 1 : 0;
        $data['mon'] = $request->has('mon') ? 1 : 0;
        $data['tue'] = $request->has('tue') ? 1 : 0;
        $data['wed'] = $request->has('wed') ? 1 : 0;
        $data['thu'] = $request->has('thu') ? 1 : 0;
        $data['fri'] = $request->has('fri') ? 1 : 0;
        $data['sat'] = $request->has('sat') ? 1 : 0;

        $shiftsetup = HrmShiftSetup::create($data);
        return redirect()->route("shiftsetup.index") -> with('success', 'Shift Setup created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrmShiftSetup $hrmShiftSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmShiftSetup $hrmShiftSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmShiftSetup $shiftsetup)
    {
        $data = $request->validate([
            'team_id' => 'required',
            'shift_id' => 'required',
            'shift_team_id' => 'required',
            'status' => 'required'
        ]);

        $data['sun'] = $request->has('sun') ? 1 : 0;
        $data['mon'] = $request->has('mon') ? 1 : 0;
        $data['tue'] = $request->has('tue') ? 1 : 0;
        $data['wed'] = $request->has('wed') ? 1 : 0;
        $data['thu'] = $request->has('thu') ? 1 : 0;
        $data['fri'] = $request->has('fri') ? 1 : 0;
        $data['sat'] = $request->has('sat') ? 1 : 0;

        $shiftsetup->update($data);
        return redirect()->route("shiftsetup.index") -> with('success', 'Shift Setup updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmShiftSetup $hrmShiftSetup)
    {
        //
    }
}
