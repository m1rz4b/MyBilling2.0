<?php

namespace App\Http\Controllers;

use App\Models\HrmEmpMonthlyDeduct;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrmEmpMonthlyDeductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $selectedYear = '';
        $selectedMonth = '';
        $hrm_emp_monthly_deduct = [];

        return view('pages.hrm.entryForm.deductionComponent', compact('menus', 'selectedMonth', 'selectedYear', 'hrm_emp_monthly_deduct'));
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
    public function show(Request $request)
    {
        $selectedYear = $request->year;
        $selectedMonth = $request->month;
        $menus = Menu::get();
        $hrm_emp_monthly_deduct = HrmEmpMonthlyDeduct::select(
        'hrm_emp_monthly_deduct.id',
        'hrm_emp_monthly_deduct.emp_id',
        'hrm_emp_monthly_deduct.year',
        'hrm_emp_monthly_deduct.month',
        'hrm_emp_monthly_deduct.deduct_comp_id',
        'hrm_emp_monthly_deduct.amnt',
        'hrm_deduct_comp.deduct_comp_name',
        'mas_employees.emp_name'
        )
        ->leftJoin('hrm_deduct_comp', 'hrm_deduct_comp.id', '=', 'hrm_emp_monthly_deduct.deduct_comp_id')
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_emp_monthly_deduct.emp_id')
        ->where('hrm_emp_monthly_deduct.year', $selectedYear)
        ->where('hrm_emp_monthly_deduct.month', $selectedMonth)
        ->get();

        return view('pages.hrm.entryForm.deductionComponent', compact('menus', 'selectedMonth', 'selectedYear', 'hrm_emp_monthly_deduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmEmpMonthlyDeduct $hrmEmpMonthlyDeduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hrmEmpMonthlyDeduct)
    {
        $user_id = Auth::id();

        $hrm_emp_monthly_deduct = HrmEmpMonthlyDeduct::find($hrmEmpMonthlyDeduct);
        $hrm_emp_monthly_deduct->amnt = $request->amnt;
        $hrm_emp_monthly_deduct->updated_by = $user_id;
        $hrm_emp_monthly_deduct->save();

        return redirect(route('deductioncomponent.index'))->with('success', 'Deducttion component has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmEmpMonthlyDeduct $hrmEmpMonthlyDeduct)
    {
        //
    }
}
