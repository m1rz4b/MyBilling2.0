<?php

namespace App\Http\Controllers;

use App\Models\Checkinout;
use App\Models\MasEmployee;
use App\Models\Menu;
use App\Models\TblSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

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
        $menus = Menu::get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

        $selectedFromDate = $request->from_date;
        $selectedToDate = $request->to_date;
        $selectedEmployee = $request->employee;

        $attendanceData = Checkinout::select(
            DB::raw("DATE_FORMAT(checkinout.checktime, '%Y-%m-%d') as empdate"),   // Format checktime
            DB::raw("DAY(checkinout.checktime) as day"),                           // Extract the day
            DB::raw("MAX(CAST(checkinout.checktime AS CHAR)) as max_checktime"),   // Get the latest checktime
            DB::raw("MIN(CAST(checkinout.checktime AS CHAR)) as min_checktime"),   // Get the earliest checktime
            DB::raw("MAX(mas_employees.emp_name) as emp_name")                     // Aggregate employee name
        )
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'checkinout.userid')
        ->groupBy(DB::raw("DATE_FORMAT(checkinout.checktime, '%Y-%m-%d')"), DB::raw('DAY(checkinout.checktime)'))  // Group by both date format and day
        ->orderBy(DB::raw("DATE_FORMAT(checkinout.checktime, '%Y-%m-%d')"), 'ASC') // Order by formatted date
        ->where('checkinout.checktime', '>=', $selectedFromDate.' 00:00:00')
        ->where('checkinout.checktime', '<=', $selectedToDate. ' 23:59:59');
        if ($selectedEmployee > -1) {
            $attendanceData->where('mas_employees.id', $selectedEmployee);
        }
        $attendanceData = $attendanceData->paginate(30)->withQueryString();

        $plannedin = TblSchedule::where('id', 1)->value('start_time');
        $plannedout = TblSchedule::where('id', 1)->value('end_time');

        foreach ($attendanceData as $attendance) {
            $max = $attendance->max_checktime;
            $max1 = explode(" ", $max);
            $max = date('g:i a', strtotime($max1[1]));

            $min = $attendance->min_checktime;
            $min1 = explode(" ", $min);
            $min = date('g:i a', strtotime($min1[1]));
        }

        $employeeName = MasEmployee::select('id', 'emp_name')->where('id', $selectedEmployee)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.actAndPlanWork', compact(
                'menus', 
                'employees', 
                'selectedFromDate',
                'selectedToDate',
                'selectedEmployee',
                'attendanceData',
                'plannedin',
                'plannedout',
                'max',
                'min',
                'employeeName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.actAndPlanWorkReport', compact(
                'selectedFromDate',
                'selectedToDate',
                'selectedEmployee',
                'attendanceData',
                'plannedin',
                'plannedout',
                'max',
                'min',
                'employeeName'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }

        return view('pages.hrm.reports.actAndPlanWork', compact(
            'menus', 
            'employees', 
            'selectedFromDate',
            'selectedToDate',
            'selectedEmployee',
            'attendanceData',
            'plannedin',
            'plannedout',
        ));
    }
}
