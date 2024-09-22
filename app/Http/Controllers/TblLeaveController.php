<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TblLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TblLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $leave_types = TblLeave::select(
            'tbl_leave.id',
            'tbl_leave.employee_id',

            DB::raw("DATE_FORMAT(tbl_leave.from_date, '%d/%m/%Y') as from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date, '%d/%m/%Y') as to_date"),
            'tbl_leave.days',
            'leave_status.status as leave_status',

            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'mas_employees.emp_name',
            'tbl_leavetype.name as leavetype_name',
            
        )
        ->leftJoin('mas_employees', 'mas_employees.emp_id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        
        ->orderBy('tbl_leave.from_date', 'desc')
        ->get();

        return view('pages.hrm.entryForm.additionComponent', compact('menus', ));
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
    public function show(TblLeave $tblLeave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblLeave $tblLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblLeave $tblLeave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblLeave $tblLeave)
    {
        //
    }
}
