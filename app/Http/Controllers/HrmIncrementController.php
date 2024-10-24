<?php

namespace App\Http\Controllers;

use App\Models\HrmIncrement;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MasDepartment;
use App\Models\MasEmployee;
use App\Models\HrmIncrementType;
use Barryvdh\DomPDF\Facade\Pdf;

class HrmIncrementController extends Controller
{
    private function getMonth($m)
    {
        if ($m == 1) {
            return "January";
        } else if ($m == 2) {
            return "February";
        } else if ($m == 3) {
            return "March";
        } else if ($m == 4) {
            return "April";
        } else if ($m == 5) {
            return "May";
        } else if ($m == 6) {
            return "June";
        } else if ($m == 7) {
            return "July";
        } else if ($m == 8) {
            return "August";
        } else if ($m == 9) {
            return "September";
        } else if ($m == 10) {
            return "October";
        } else if ($m == 11) {
            return "November";
        } else if ($m == 12) {
            return "December";
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();

        $hrm_increments = HrmIncrement::select(
            'hrm_increments.id',
            'hrm_increments.emp_id',
            'hrm_increments.month',
            'hrm_increments.year',
            'hrm_increments.previous_gross',
            'hrm_increments.increment_percent',
            'hrm_increments.increment_amount',
            'hrm_increments.current_gross',
            'hrm_increments.increment_type',
            'mas_employees.department',
            'hrm_increments.entry_date'
        )
            ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_increments.emp_id')
            ->leftJoin('hrm_increment_types', 'hrm_increment_types.id', '=', 'hrm_increments.increment_type')
            ->get();

        $mas_departments = MasDepartment::select('id', 'department')->orderBy('department', 'desc')->get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->get();
        $hrm_increment_types = HrmIncrementType::select('id', 'name')->orderBy('name', 'desc')->get();
        return view('pages.hrm.entryForm.hrmIncrement', compact('menus', 'hrm_increments', 'mas_departments', 'mas_employees', 'hrm_increment_types'));
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
    public function show(HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmIncrement $hrmIncrement)
    {
        //
    }

    // Employee Increment Report
    public function employeeIncrementIndex()
    {
        $menus = Menu::get();
        $selectedYear = '';
        $selectedMonth = '';
        $selectedIgnoreMonth = 1;
        $selectedDepartment = '';
        $selectedIncrementType = '';
        $hrm_increments = [];

        $mas_departments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $hrm_increment_types = HrmIncrementType::select('id', 'name')->orderBy('id', 'asc')->get();
        return view('pages.hrm.reports.employeeIncrement', compact('menus', 'selectedYear', 'selectedMonth', 'selectedIgnoreMonth', 'selectedDepartment', 'selectedIncrementType', 'mas_departments', 'hrm_increment_types', 'hrm_increments'));
    }

    public function employeeIncrementShow(Request $request)
    {
        // dd($request);
        $menus = Menu::get();
        $selectedYear = $request->year;
        $selectedMonth = $request->month;
        $selectedIgnoreMonth = $request->ignore_month;
        $selectedDepartment = $request->department;
        $selectedIncrementType = $request->increment_type;

        $hrm_increments = HrmIncrement::select(
            'hrm_increments.id',
            'hrm_increments.emp_id',
            'hrm_increments.month',
            'hrm_increments.year',
            'hrm_increments.previous_gross',
            'hrm_increments.increment_percent',
            'hrm_increments.increment_amount',
            'hrm_increments.current_gross',

            'mas_employees.emp_name',
            'hrm_increment_types.name',
            'hrm_increments.approve_date',
            'hrm_increments.entry_date'
        )
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_increments.emp_id')
        ->leftJoin('hrm_increment_types', 'hrm_increment_types.id', '=', 'hrm_increments.increment_type');
        if($selectedYear !='' ){
            $hrm_increments->where('approve_status', 1)
            ->where('year', $selectedYear);
		}
        if ($selectedIgnoreMonth!=1) {
            if ($selectedMonth!=''){
                $hrm_increments->where('approve_status', 1)
                ->where('month', $selectedMonth);
            }
		}
        if ($selectedDepartment>-1) {
            $hrm_increments->where('mas_employees.department',$selectedDepartment);
        }
        if ($selectedIncrementType>-1) {
            $hrm_increments->where('hrm_increments.increment_type',$selectedIncrementType);
        }
        foreach ($hrm_increments as $hrm_increment) {
            $hrm_increment->month = $this->getMonth($hrm_increment->month);

            $hrm_increment->push(['extra_column' => 1]);
        }
        $hrm_increments = $hrm_increments->get();        

        $tprevious_gross=0;
        $tincrement_amount=0;
        $tcurrent_gross=0;
        foreach ($hrm_increments as $hrm_increment) {
            $tprevious_gross = $tprevious_gross + $hrm_increment->previous_gross;
            $tincrement_amount = $tincrement_amount + $hrm_increment->increment_amount;
            $tcurrent_gross = $tcurrent_gross + $hrm_increment->current_gross;
        }

        $mas_departments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $hrm_increment_types = HrmIncrementType::select('id', 'name')->orderBy('id', 'asc')->get();

        foreach ($hrm_increments as $hrm_increment) {
            $hrm_increment['month'] = $this->getMonth($hrm_increment->month);
        }

        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $incrementTypeName = HrmIncrementType::select('id', 'name')->where('id', $selectedIncrementType)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.employeeIncrement', compact(
                'menus', 
                'selectedYear', 
                'selectedMonth', 
                'selectedIgnoreMonth', 
                'selectedDepartment', 
                'selectedIncrementType', 
                'hrm_increments', 
                'mas_departments',
                'hrm_increment_types', 
                'tprevious_gross', 
                'tincrement_amount', 
                'tcurrent_gross',
                'departmentName',
                'incrementTypeName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.employeeIncrementReport', compact(
                'selectedYear', 
                'selectedMonth', 
                'hrm_increments', 
                'tprevious_gross', 
                'tincrement_amount', 
                'tcurrent_gross',
                'departmentName',
                'incrementTypeName'
            ))->setPaper('a4', 'landscape');
            return $pdf->download('invoices.pdf');
        }
    }
}
