<?php

namespace App\Http\Controllers;

use App\Models\HrmSalaryAdvanced;
use App\Models\MasEmployee;
use App\Models\Menu;
use Illuminate\Http\Request;

class HrmSalaryAdvancedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $salaryadvanced = HrmSalaryAdvanced::get();
        $employees = MasEmployee::get();
        return view('pages.hrm.payroll.entryForm.salaryAdvanced', compact('menus', 'salaryadvanced', 'employees'));
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
    public function show(HrmSalaryAdvanced $hrmSalaryAdvanced)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmSalaryAdvanced $hrmSalaryAdvanced)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmSalaryAdvanced $hrmSalaryAdvanced)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmSalaryAdvanced $hrmSalaryAdvanced)
    {
        //
    }
}
