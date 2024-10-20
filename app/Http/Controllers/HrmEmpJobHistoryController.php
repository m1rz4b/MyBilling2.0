<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\HrmEmpJobHistory;
use App\Models\MasDepartment;
use App\Models\MasEmployee;
use App\Models\Menu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HrmEmpJobHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name', 'asc')->get();
        $designations = Designation::select('id', 'designation')->orderBy('designation','asc')->get();
        $emp_job_histories = HrmEmpJobHistory::select(
                'hrm_emp_job_history.id',
                'hrm_emp_job_history.designation',
                DB::raw("DATE_FORMAT(hrm_emp_job_history.pro_date, '%d/%m/%Y') as pro_date"),
                DB::raw("DATE_FORMAT(hrm_emp_job_history.pre_pro_date, '%d/%m/%Y') as pre_pro_date"),
                'b.designation as prodes',
                'c.designation as predes',
                'mas_employees.emp_name'
            )
            ->leftJoin('mas_designation as b', 'b.id', '=', 'hrm_emp_job_history.designation')
            ->leftJoin('mas_designation as c', 'c.id', '=', 'hrm_emp_job_history.pre_designation')
            ->leftJoin('mas_employees', 'hrm_emp_job_history.emp_id', '=', 'mas_employees.id')
            ->orderBy('hrm_emp_job_history.pro_date', 'desc')
            ->get();

        return view('pages.hrm.entryForm.employeePromotion', compact('menus', 'employees', 'designations', 'emp_job_histories'));
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
        $user_id = Auth::id();

        HrmEmpJobHistory::create([
            'emp_id' => ($request->emp_id == null) ? '' : $request->emp_id,
            'designation' => ($request->designation == null) ? '' : $request->designation,
            'pro_date' => ($request->pro_date == null) ? '' : $request->pro_date,
            'created_by' => $user_id
        ]);

        return redirect(route('employeepromotion.index'))->with('success', 'Promotion added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrmEmpJobHistory $hrmEmpJobHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmEmpJobHistory $hrmEmpJobHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hrmEmpJobHistory)
    {
        $user_id = Auth::id();

        $job_history = HrmEmpJobHistory::find($hrmEmpJobHistory);
        $job_history->emp_id = $request->emp_id;
        $job_history->designation = $request->designation;
        $job_history->pro_date = $request->pro_date;
        $job_history->updated_by = $user_id;
        $job_history->save();

        return redirect(route('employeepromotion.index'))->with('success', 'Promotion has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmEmpJobHistory $hrmEmpJobHistory)
    {
        //
    }

    // Employee Promotion Report
    public function employeePromotionIndex()
    {
        $menus = Menu::get();
        $selectedYear = '';
        $selectedMonth = '';
        $selectedDepartment = '';
        $hrmEmpJobHistory = [];

        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        return view('pages.hrm.reports.employeePromotion', compact('menus', 'selectedYear', 'selectedMonth', 'selectedDepartment', 'hrmEmpJobHistory', 'masDepartments'));
    }

    public function employeePromotionShow(Request $request)
    {
        $menus = Menu::get();
        $selectedYear = $request->year;
        $selectedMonth = $request->month;
        $selectedDepartment = $request->department;

        $hrmEmpJobHistory = HrmEmpJobHistory::select(
        'hrm_emp_job_history.id',
            DB::raw("DATE_FORMAT(hrm_emp_job_history.pro_date, '%d/%m/%Y') as pro_date"),
            DB::raw("DATE_FORMAT(hrm_emp_job_history.pre_pro_date, '%d/%m/%Y') as pre_pro_date"),
            'b.designation as prodes',
            'c.designation as predes',
            'mas_employees.emp_name',
        )
        ->leftJoin('mas_designation as b', 'b.id', '=', 'hrm_emp_job_history.designation')
        ->leftJoin('mas_designation as c', 'c.id', '=', 'hrm_emp_job_history.pre_designation')
        ->leftJoin('mas_employees', 'hrm_emp_job_history.emp_id', '=', 'mas_employees.id');
        if($selectedYear !='' && $selectedMonth!=''){
            $hrmEmpJobHistory->whereMonth('pro_date', 10)
            ->whereYear('pro_date', 2020);
        }
        if ($selectedDepartment>-1) {
            $hrmEmpJobHistory->where('mas_employees.department',$selectedDepartment);
        }
        $hrmEmpJobHistory = $hrmEmpJobHistory->paginate(20)->withQueryString();

        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.employeePromotion', compact(
                'menus', 
                'selectedYear', 
                'selectedMonth', 
                'selectedDepartment', 
                'hrmEmpJobHistory', 
                'masDepartments',
                'departmentName'
            ));
        } else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.employeePromotionReport', compact(
                'selectedYear', 
                'selectedMonth', 
                'hrmEmpJobHistory',
                'departmentName'
            ))->setPaper('a4', 'portrait');
            return $pdf->download('invoices.pdf');
        }
    }
}