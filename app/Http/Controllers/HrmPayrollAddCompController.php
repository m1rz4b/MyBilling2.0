<?php

namespace App\Http\Controllers;

use App\Models\GlCode;
use App\Models\HrmAddComp;
use App\Models\HrmCompType;
use App\Models\Menu;
use Illuminate\Http\Request;

class HrmPayrollAddCompController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $addcomps = HrmAddComp::get();
        $comptypes = HrmCompType::get();
        $masgls = GlCode::get();

        return view('pages.hrm.payroll.setup.payrollAdditionComponent', compact('menus', 'addcomps', 'comptypes', 'masgls'));
    }

    public function addcompreport()
    {
        $menus = Menu::get();
        $addcomps = HrmAddComp::get();
        $selectedYear = '';
        $selectedMonth = '';
        $selectedAddComp = '';
        return view('pages.hrm.payroll.report.additionComponent', compact('menus', 'addcomps', 'selectedYear', 'selectedMonth', 'selectedAddComp'));
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
            'addcomp' => 'required',
            'type' => 'required',
            'percent' => 'required',
            'amount' => 'required',
            'glcode' => 'required'
        ]);

        $payaddcomp = HrmAddComp::create([
            'add_comp_name' => $request->addcomp,
            'type' => $request->type,
            'percent' => $request->percent,
            'amnt' => $request->amount,
            'gl_code' => $request->glcode
        ]);
        return redirect()->route('payrolladdcomponent.index') -> with('success', 'Addition Component Added Successfully');
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
    public function update(Request $request, HrmAddComp $payrolladdcomponent)
    {
        //
        $data = $request->validate([
            'addcomp' => 'required',
            'type' => 'required',
            'percent' => 'required',
            'amount' => 'required',
            'glcode' => 'required'
        ]);

        $payrolladdcomponent->update([
            'add_comp_name' => $request->addcomp,
            'type' => $request->type,
            'percent' => $request->percent,
            'amnt' => $request->amount,
            'gl_code' => $request->glcode
        ]);
        return redirect()->route('payrolladdcomponent.index') -> with('success', 'Addition Component Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
