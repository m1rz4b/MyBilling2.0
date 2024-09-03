<?php

namespace App\Http\Controllers;

use App\Models\TblHoliday;
use Illuminate\Http\Request;
use App\Models\Menu;

class TblHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $holidays = TblHoliday::get();
        return view('pages.hrm.holiday', compact('menus', 'holidays'));
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
        $storeData = $request->validate([
            'holiday_name' => 'required|string',
            'holiday_date' => 'required'
        ]);

        $user_id = 1; //Replace by Auth later

        $newHoliday = TblHoliday::create([
            'holiday_name' => ($request->holiday_name == null) ? '' : $request->holiday_name,
            'holiday_date' => ($request->holiday_date == null) ? '' : $request->holiday_date,
            'allowance_status' => ($request->allowance_status == null) ? '' : $request->allowance_status,
            'status' => ($request->status == null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('holiday.index'))->with('success', 'Holiday added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblHoliday $tblHoliday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblHoliday $tblHoliday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tblHoliday)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'holiday_name' => 'required|string',
            'holiday_date' => 'required'
        ]);

        $holidays = TblHoliday::find($tblHoliday);
        $holidays->holiday_name = $request->holiday_name;
        $holidays->holiday_date = $request->holiday_date;
        $holidays->allowance_status = $request->allowance_status;
        $holidays->status = $request->status;
        $holidays->updated_by = $user_id;
        $holidays->save();

        return redirect(route('holiday.index'))->with('success', 'Holiday has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tblHoliday = null)
    {
        $user_id = 1; //Replace by Auth later

        $holidays = TblHoliday::find($tblHoliday);
        $holidays->deleted_by = $user_id;
        $holidays->save();
        $holidays->delete();
        return redirect(route('holiday.index'))->with('success', 'Holiday has been deleted successfully');
    }
}
