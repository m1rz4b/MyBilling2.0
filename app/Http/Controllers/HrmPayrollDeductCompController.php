<?php

namespace App\Http\Controllers;

use App\Models\GlCode;
use App\Models\HrmCompType;
use App\Models\HrmDeductComp;
use App\Models\Menu;
use Illuminate\Http\Request;

class HrmPayrollDeductCompController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $deductcomps = HrmDeductComp::get();
        $comptypes = HrmCompType::get();
        $masgls = GlCode::get();

        return view('pages.hrm.payroll.setup.payrollDeductionComponent', compact('menus', 'deductcomps', 'comptypes', 'masgls'));
    }

    public function deductcompreport()
    {
        $menus = Menu::get();
        $deductcomps = HrmDeductComp::get();
        $selectedYear = '';
        $selectedMonth = '';
        $selectedDeductComp = '';
        return view('pages.hrm.payroll.report.deductionComponent', compact('menus', 'deductcomps', 'selectedYear', 'selectedMonth', 'selectedDeductComp'));
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
        $data = $request->validate([
            'deductcomp' => 'required',
            'type' => 'required',
            'percent' => 'required',
            'amount' => 'required',
            'glcode' => 'required'
        ]);
        
        $payaddcomp = HrmDeductComp::create([
            'deduct_comp_name' => $request->deductcomp,
            'type' => $request->type,
            'percent' => $request->percent,
            'amnt' => $request->amount,
            'gl_code' => $request->glcode
        ]);
        return redirect()->route('payrolldeductcomponent.index') -> with('success', 'Deduction Component Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmDeductComp $payrolldeductcomponent)
    {
        //
        $data = $request->validate([
            'deductcomp' => 'required',
            'type' => 'required',
            'percent' => 'required',
            'amount' => 'required',
            'glcode' => 'required'
        ]);

        $payrolldeductcomponent->update([
            'deduct_comp_name' => $request->deductcomp,
            'type' => $request->type,
            'percent' => $request->percent,
            'amnt' => $request->amount,
            'gl_code' => $request->glcode
        ]);
        return redirect()->route('payrolldeductcomponent.index') -> with('success', 'Deduction Component Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
