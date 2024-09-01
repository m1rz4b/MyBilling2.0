<?php

namespace App\Http\Controllers;

use App\Models\HrmTblShift;
use App\Models\Menu;
use App\Models\TblSchedule;
use Illuminate\Http\Request;

class TblScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $schedules = TblSchedule::get();
        return view('pages.hrm.shift', compact('menus', 'schedules'));
    }

    public function shiftschdlIndex()
    {
        $menus = Menu::get();
        $hrm_tblshifts = HrmTblShift::get();
        return view('pages.hrm.shiftSchedule', compact('menus', 'hrm_tblshifts'));
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
            'sch_name'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'late_time'=>'required',
            'begining_start'=>'required',
            'begining_end'=>'required',
            'out_start'=>'required',
            'out_end'=>'required',
            'status'=>'required'
        ]);

        $schedule = TblSchedule::create($data);
        return redirect() -> route('shift.index') -> with('success', 'Schedule created successfully');
    }

    public function shiftschdlStore(Request $request)
    {
        $data = $request->validate([
            'shift_name'=>'required', 
            'start_time'=>'required', 
            'end_time'=>'required', 
            'begining_start'=>'required', 
            'begining_end'=>'required', 
            'out_start'=>'required', 
            'out_end'=>'required', 
            'status'=>'required'
        ]);

        $shiftschdl = HrmTblShift::create($data);
        return redirect() -> route('shiftschedule.shiftschdlIndex') -> with('success', 'Shift Schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblSchedule $tblSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblSchedule $tblSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblSchedule $shift)
    {
        $data = $request->validate([
            'sch_name'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'late_time'=>'required',
            'begining_start'=>'required',
            'begining_end'=>'required',
            'out_start'=>'required',
            'out_end'=>'required',
            'status'=>'required'
        ]);

        $shift->update($data);
        return redirect() -> route('shift.index') -> with('success', 'Schedule updated successfully');
    }

    public function shiftschdlUpdate(Request $request, HrmTblShift $shiftschedule)
    {
        $data = $request->validate([
            'shift_name'=>'required', 
            'start_time'=>'required', 
            'end_time'=>'required', 
            'begining_start'=>'required', 
            'begining_end'=>'required', 
            'out_start'=>'required', 
            'out_end'=>'required', 
            'status'=>'required'
        ]);

        $shiftschedule->update($data);
        return redirect() -> route('shiftschedule.shiftschdlIndex') -> with('success', 'Shift Schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tblSchedule = null)
    {
        $user_id = 1; //Replace by Auth later

        $shift = TblSchedule::find($tblSchedule);
        $shift->deleted_by = $user_id;
        $shift->save();
        $shift->delete();
        return redirect(route('shift.index'))->with('success', 'Shift has been deleted successfully');
    }

    public function shiftschdlDelete($shiftschedule = null)
    {
        $user_id = 1; //Replace by Auth later

        $shiftschedule = HrmTblShift::find($shiftschedule);
        $shiftschedule->deleted_by = $user_id;
        $shiftschedule->save();
        $shiftschedule->delete();
        return redirect(route('shiftschedule.shiftschdlIndex'))->with('success', 'Shift Schedule has been deleted successfully');
    }
}
