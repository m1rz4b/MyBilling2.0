<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TblScheduleTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TblScheduleTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $scheduleteams = TblScheduleTeam::get();
        $companies = DB::table('tbl_company')
                    ->select('company_name')
                    ->where('id', '=', 1)
                    ->get();
        $stviews = DB::table('hrm_shift_setup')
                    ->select('tbl_schedule_team.team_name', 'hrm_tbl_shift.shift_name')
                    ->selectRaw('GROUP_CONCAT(IF(sun=1,tbl_shift_team.level,"")) AS sun')
                    ->selectRaw('GROUP_CONCAT(IF(mon=1,tbl_shift_team.level,"")) AS mon')
                    ->selectRaw('GROUP_CONCAT(IF(tue=1,tbl_shift_team.level,"")) AS tue')
                    ->selectRaw('GROUP_CONCAT(IF(wed=1,tbl_shift_team.level,"")) AS wed')
                    ->selectRaw('GROUP_CONCAT(IF(thu=1,tbl_shift_team.level,"")) AS thu')
                    ->selectRaw('GROUP_CONCAT(IF(fri=1,tbl_shift_team.level,"")) AS fri')
                    ->selectRaw('GROUP_CONCAT(IF(sat=1,tbl_shift_team.level,"")) AS sat')
                    ->leftJoin('hrm_tbl_shift', 'hrm_tbl_shift.id', '=', 'hrm_shift_setup.shift_id')
                    ->leftJoin('tbl_schedule_team', 'tbl_schedule_team.id', '=', 'hrm_shift_setup.team_id')
                    ->leftJoin('tbl_shift_team', 'tbl_shift_team.id', '=', 'hrm_shift_setup.shift_team_id')
                    ->groupBy('tbl_schedule_team.team_name', 'hrm_tbl_shift.shift_name')
                    ->orderBy('hrm_tbl_shift.shift_name', 'DESC')
                    ->get();
        $shiftemployees = DB::table('tbl_shift_team')
                    ->select('level', 'mas_employees.empl_name')
                    ->join('mas_employees', 'mas_employees.id', '=', 'tbl_shift_team.emp_id')
                    ->get();
        return view('pages.hrm.scheduleTeam', compact('menus', 'scheduleteams', 'companies', 'stviews', 'shiftemployees'));
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
            'team_name' => 'required',
            'status' => 'required'
        ]);

        $scheduleteam = TblScheduleTeam::create($data);
        return redirect()->route('scheduleteam.index') -> with('success', 'Schedule Team created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblScheduleTeam $tblScheduleTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblScheduleTeam $tblScheduleTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblScheduleTeam $scheduleteam)
    {
        $data = $request->validate([
            'team_name' => 'required',
            'status' => 'required'
        ]);

        $scheduleteam->update($data);
        return redirect()->route('scheduleteam.index') -> with('success', 'Schedule Team updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tblScheduleTeam = null)
    {
        $user_id = 1; //Replace by Auth later

        $scheduleteam = TblScheduleTeam::find($tblScheduleTeam);
        $scheduleteam->deleted_by = $user_id;
        $scheduleteam->save();
        $scheduleteam->delete();
        return redirect(route('scheduleteam.index'))->with('success', 'Schedule Team has been deleted successfully');
    }
}
