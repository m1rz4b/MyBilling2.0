<?php

namespace App\Http\Controllers;

use App\Models\HrmEmploanStatus;
use App\Models\HrmTblEmploan;
use App\Models\MasEmployee;
use App\Models\Menu;
use Illuminate\Http\Request;

class HrmTblEmploanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $tblemploans = HrmTblEmploan::get();
        $hrmloanstatuses = HrmEmploanStatus::get();
        $employees = MasEmployee::get();

        return view('pages.hrm.payroll.entryForm.employeeLoan', compact('menus', 'tblemploans', 'hrmloanstatuses', 'employees'));
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
            'emp_id' => 'required',
            'sanction_date' => 'required',
            'start_date' => 'required',
            'amnt' => 'required',
            'interest' => 'required',
            'no_of_installment' => 'required',
            'emi' => 'required',
            'status' => 'required'
        ]);

        $emploan = HrmTblEmploan::create($data);
        return redirect()->route('emploan.index') -> with('success', 'Employee Loan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrmTblEmploan $hrmTblEmploan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmTblEmploan $hrmTblEmploan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmTblEmploan $emploan)
    {
        //
        $data = $request->validate([
            'emp_id' => 'required',
            'sanction_date' => 'required',
            'start_date' => 'required',
            'amnt' => 'required',
            'interest' => 'required',
            'no_of_installment' => 'required',
            'emi' => 'required',
            'status' => 'required'
        ]);

        $emploan->update($data);
        return redirect()->route('emploan.index') -> with('success', 'Employee Loan updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmTblEmploan $hrmTblEmploan)
    {
        //
    }
}
