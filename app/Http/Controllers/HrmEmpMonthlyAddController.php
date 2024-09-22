<?php

namespace App\Http\Controllers;

use App\Models\HrmAddComp;
use App\Models\HrmEmpMonthlyAdd;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrmEmpMonthlyAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $selectedYear = '';
        $selectedMonth = '';
        $hrm_emp_monthly_add = [];

        return view('pages.hrm.entryForm.additionComponent', compact('menus', 'selectedMonth', 'selectedYear', 'hrm_emp_monthly_add'));
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
        $hrm_emp_monthly_add = HrmEmpMonthlyAdd::select(
        'hrm_emp_monthly_add.id',
        'hrm_emp_monthly_add.emp_id',
        'hrm_emp_monthly_add.year',
        'hrm_emp_monthly_add.month',
        'hrm_emp_monthly_add.add_comp_id',
        'hrm_emp_monthly_add.amnt',
        'hrm_add_comp.add_comp_name',
        'mas_employees.emp_name'
        )
        ->leftJoin('hrm_add_comp', 'hrm_add_comp.id', '=', 'hrm_emp_monthly_add.add_comp_id')
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_emp_monthly_add.emp_id')
        ->where('hrm_emp_monthly_add.year', $selectedYear)
        ->where('hrm_emp_monthly_add.month', $selectedMonth)
        ->get();

        // dd($hrm_emp_monthly_add);

        return view('pages.hrm.entryForm.additionComponent', compact('menus', 'selectedMonth', 'selectedYear', 'hrm_emp_monthly_add'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmEmpMonthlyAdd $hrmEmpMonthlyAdd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hrmEmpMonthlyAdd)
    {
        $user_id = Auth::id();

        $hrm_emp_monthly_add = HrmEmpMonthlyAdd::find($hrmEmpMonthlyAdd);
        $hrm_emp_monthly_add->amnt = $request->amnt;
        $hrm_emp_monthly_add->updated_by = $user_id;
        $hrm_emp_monthly_add->save();

        return redirect(route('additioncomponent.index'))->with('success', 'Addition component has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmEmpMonthlyAdd $hrmEmpMonthlyAdd)
    {
        //
    }
}
