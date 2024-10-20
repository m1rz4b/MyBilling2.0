<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Models\MasEmployee;
use App\Models\Menu;
use App\Models\TblLeave;
use App\Models\TblLeaveDayType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TblLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedFromDate = '';
        $selectedToDate = '';
        $selectedEmployee = '';

        $menus = Menu::get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $employees_modal = MasEmployee::select(
            'mas_employees.id as emp_id',
            DB::raw('CONCAT(emp_name, " => ", mas_departments.department, " => ", mas_designation.designation) as employee_details')
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->get();
        $leave_day_types = TblLeaveDayType::select('id', 'name')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();

        $tbl_leaves = TblLeave::select(
            'tbl_leave.id',
            'tbl_leave.day_type',
            'tbl_leave.employee_id',
            DB::raw("DATE_FORMAT(tbl_leave.from_date, '%d/%m/%Y') as from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date, '%d/%m/%Y') as to_date"),
            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'tbl_leave.days',
            'mas_employees.emp_name',
            'tbl_leavetype.name as leavetype_name',
            'leave_status.status as leave_status'
        )
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        ->orderBy('tbl_leave.from_date', 'asc')
        ->paginate(30);

        return view('pages.hrm.entryForm.employeeLeave', compact('menus', 'mas_employees', 'employees_modal', 'leave_day_types', 'leave_types', 'tbl_leaves', 'selectedFromDate', 'selectedToDate', 'selectedEmployee'));
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

        $newLeaveType = TblLeave::create([
            'employee_id' => ($request->employee_id == null) ? '' : $request->employee_id,
            'day_type' => ($request->day_type == null) ? '' : $request->day_type,
            'from_date' => ($request->from_date == null) ? '' : $request->from_date,
            'to_date' => ($request->to_date == null) ? '' : $request->to_date,
            'days' => ($request->days == null) ? '' : $request->days,
            'leavetype_id' => ($request->leavetype_id == null) ? '' : $request->leavetype_id,
            'remarks' => ($request->remarks == null) ? '' : $request->remarks,
            'created_by' => $user_id
        ]);

        return redirect(route('employeeleave.index'))->with('success', 'Employee Leave added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $selectedFromDate = $request->txtfromopen_date;
        $selectedToDate = $request->txttoopen_date;
        $selectedEmployee = $request->employee;

        $menus = Menu::get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $employees_modal = MasEmployee::select(
            'mas_employees.id as emp_id',
            DB::raw('CONCAT(emp_name, " => ", mas_departments.department, " => ", mas_designation.designation) as employee_details')
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->get();
        $leave_day_types = TblLeaveDayType::select('id', 'name')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();

        $tbl_leaves = TblLeave::select(
            'tbl_leave.id',
            'tbl_leave.day_type',
            'tbl_leave.employee_id',
            DB::raw("DATE_FORMAT(tbl_leave.from_date, '%d/%m/%Y') as from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date, '%d/%m/%Y') as to_date"),
            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'tbl_leave.days',
            'mas_employees.emp_name',
            'tbl_leavetype.name as leavetype_name',
            'leave_status.status as leave_status'
        )
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        ->orderBy('tbl_leave.from_date', 'asc');
        if ($selectedFromDate && $selectedToDate) {
            $start_date = Carbon::parse($selectedFromDate);
            $end_date = Carbon::parse($selectedToDate);      
            $tbl_leaves->where(DB::raw('DATE_FORMAT(from_date,"%Y-%m-%d")'),'>=',$selectedFromDate);
            $tbl_leaves->where(DB::raw('DATE_FORMAT(from_date,"%Y-%m-%d")'),'<=', $selectedToDate);
        }

        if ($selectedEmployee>-1) {
                $tbl_leaves->where('employee_id', $selectedEmployee);
        }
        $tbl_leaves = $tbl_leaves->paginate(30);
        // dd($tbl_leaves);
        return view('pages.hrm.entryForm.employeeLeave', compact('menus', 'mas_employees', 'employees_modal', 'leave_day_types', 'leave_types', 'tbl_leaves', 'selectedFromDate', 'selectedToDate', 'selectedEmployee'));
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
    public function update(Request $request, $tblLeave)
    {
        $user_id = Auth::id();

        $tbl_leave = TblLeave::find($tblLeave);
        $tbl_leave->employee_id = $request->employee_id;
        $tbl_leave->day_type = $request->day_type;
        $tbl_leave->from_date = $request->from_date;
        $tbl_leave->to_date = $request->to_date;
        $tbl_leave->days = $request->days;
        $tbl_leave->leavetype_id = $request->leavetype_id;
        $tbl_leave->remarks = $request->remarks;
        $tbl_leave->updated_by = $user_id;
        $tbl_leave->save();

        return redirect(route('employeeleave.index'))->with('success', 'Employee Leave has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblLeave $tblLeave)
    {
        //
    }

    public function approveLeaveIndex()
    {
        $selectedFromDate = '';
        $selectedToDate = '';
        $selectedEmployee = '';

        $menus = Menu::get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $leave_day_types = TblLeaveDayType::select('id', 'name')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();
        $user_id = Auth::id();

        $tbl_leaves = TblLeave::select([
            'tbl_leave.id',
            'tbl_leave.employee_id',
            'tbl_leave.day_type',
            DB::raw("DATE_FORMAT(tbl_leave.from_date,'%d/%m/%Y') as from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date,'%d/%m/%Y') as to_date"),
            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'tbl_leave.days',
            'tbl_leave.approved_time',
            'tbl_leave.approve_remarks',
            'mas_employees.emp_name',
            'tbl_leavetype.name as leavetype_name',
            'leave_status.status as leave_status'
        ])
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        ->orderBy('tbl_leave.from_date', 'desc')
        ->paginate(30);

        // dd($tbl_leaves );

        return view('pages.hrm.entryForm.approveLeave', compact('menus', 'mas_employees', 'leave_day_types', 'leave_types', 'user_id', 'tbl_leaves', 'selectedFromDate', 'selectedToDate', 'selectedEmployee'));
    }

    public function approveLeaveShow(Request $request)
    {
        $selectedFromDate = $request->txtfromopen_date;
        $selectedToDate = $request->txttoopen_date;
        $selectedEmployee = $request->employee;

        $menus = Menu::get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $leave_day_types = TblLeaveDayType::select('id', 'name')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();
        $user_id = Auth::id();

        $tbl_leaves = TblLeave::select([
            'tbl_leave.id',
            'tbl_leave.employee_id',
            'tbl_leave.day_type',
            DB::raw("DATE_FORMAT(tbl_leave.from_date,'%d/%m/%Y') as from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date,'%d/%m/%Y') as to_date"),
            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'tbl_leave.days',
            'tbl_leave.approved_time',
            'tbl_leave.approve_remarks',
            'mas_employees.emp_name',
            'tbl_leavetype.name as leavetype_name',
            'leave_status.status as leave_status'
        ])
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        ->orderBy('tbl_leave.from_date', 'desc');
        if ($selectedFromDate && $selectedToDate) {
            $start_date = Carbon::parse($selectedFromDate);
            $end_date = Carbon::parse($selectedToDate);      
            $tbl_leaves->where(DB::raw('DATE_FORMAT(from_date,"%Y-%m-%d")'),'>=',$selectedFromDate);
            $tbl_leaves->where(DB::raw('DATE_FORMAT(from_date,"%Y-%m-%d")'),'<=', $selectedToDate);
        }
        if ($selectedEmployee>-1) {
            $tbl_leaves->where('employee_id', $selectedEmployee);
        }
        $tbl_leaves = $tbl_leaves->paginate(30);

        return view('pages.hrm.entryForm.approveLeave', compact('menus', 'mas_employees', 'leave_day_types', 'leave_types', 'user_id', 'tbl_leaves', 'selectedFromDate', 'selectedToDate', 'selectedEmployee'));
    }

    public function approveLeavelUpdate(Request $request)
    {
        dd($request);
    }

    //Leave Transaction Report
    public function leaveTransactionIndex()
    {
        $menus = Menu::get();
        
        $leaves = TblLeave::leftJoin('mas_employees', 'mas_employees.id', '=', 'tbl_leave.employee_id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'tbl_leave.leavetype_id')
        ->leftJoin('leave_status', 'leave_status.id', '=', 'tbl_leave.status')
        ->select(
            'tbl_leave.id',
            'tbl_leave.employee_id',
            DB::raw("DATE_FORMAT(tbl_leave.from_date, '%d/%m/%Y') AS from_date"),
            DB::raw("DATE_FORMAT(tbl_leave.to_date, '%d/%m/%Y') AS to_date"),
            DB::raw("DATE_FORMAT(tbl_leave.approved_time, '%d/%m/%Y') AS approved_time"),
            'tbl_leave.leavetype_id',
            'tbl_leave.remarks',
            'tbl_leave.status',
            'tbl_leave.days',
            'mas_employees.emp_name',
            'tbl_leavetype.name AS leavetype_name',
            'leave_status.status AS leave_status'
        )
        ->paginate(50);

        return view('pages.hrm.reports.leaveTransaction', compact(
            'menus', 
            'leaves'
        ));
    }
}
