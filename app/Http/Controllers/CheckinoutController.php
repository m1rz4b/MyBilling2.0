<?php

namespace App\Http\Controllers;

use App\Models\Checkinout;
use App\Models\MasEmployee;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkinout $checkinout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkinout $checkinout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkinout $checkinout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkinout $checkinout)
    {
        //
    }

        //Actual and Plan Work
    public function actAndPlanWorkIndex()
    {
        $menus = Menu::get();

        $employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name', 'asc')->get();

        $selectedFromDate = '';
        $selectedToDate = '';
        $selectedEmployee = '';
        $attendanceData = [];

        return view('pages.hrm.reports.actAndPlanWork', compact(
            'menus', 
            'employees', 
            'selectedFromDate',
            'selectedToDate',
            'selectedEmployee',
            'attendanceData' 
        ));
    }

    public function actAndPlanWorkShow(Request $request)
    {
        // dd($request);
        $menus = Menu::get();

        $employees = MasEmployee::select('id', 'emp_name')->get();

        $selectedFromDate = $request->from_date;
        $selectedToDate = $request->to_date;
        $selectedEmployee = $request->employee;
        
        $attendanceData = Checkinout::select(
            DB::raw("DATE_FORMAT(checkinout.checktime, '%d/%m/%Y') as empdate"),
            DB::raw("DAY(checkinout.checktime) AS day"),
            'checkinout.checktime',
            DB::raw("MAX(CAST(checkinout.checktime AS CHAR)) as max_checktime"),
            DB::raw("MIN(CAST(checkinout.checktime AS CHAR)) as min_checktime"),
            'mas_employees.emp_name'
        )
        ->leftJoin('mas_employees', 'mas_employees.emp_no', '=', 'checkinout.userid')
        ->groupBy(DB::raw('DAY(checkinout.checktime)'), 'checkinout.checktime', 'mas_employees.emp_name')
        ->orderBy('checkinout.checktime', 'ASC')
        ->get();
        // dd($attendanceData);

        // if ($selectedEmployee>-1) {
        //     $attendanceData->where('mas_employees.suboffice_id',$selectedEmployee);
        // }
        // $attendanceData = $attendanceData->get();

        return view('pages.hrm.reports.actAndPlanWork', compact(
            'menus', 
            'employees', 
            'selectedFromDate',
            'selectedToDate',
            'selectedEmployee',
            'attendanceData' 
        ));
    }
}
