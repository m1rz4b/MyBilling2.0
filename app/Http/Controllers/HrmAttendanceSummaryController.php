<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\HrmAttendanceSummary;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use App\Models\MasEmployee;
use App\Models\TblSuboffice;
use App\Models\MasDepartment;

class HrmAttendanceSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name','asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department','asc')->get();
        $attendanceSummeries = HrmAttendanceSummary::select('hrm_attendance_summary.*', 'mas_employees.emp_name', 'mas_designation.designation', 'tbl_suboffices.name')
            ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_attendance_summary.employee_id')
            ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
            ->leftJoin('tbl_suboffices', 'tbl_suboffices.id', '=', 'mas_employees.suboffice_id')
            ->orderBy('hrm_attendance_summary.date', 'desc')
            ->get();

        return view('pages.hrm.entryForm.administrative', compact('menus', 'attendanceSummeries', 'employees', 'suboffices', 'departments'));
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
        $request->validate(
            [
                'employee_id' => 'integer',
                'date' => 'date',
                'start_date' => 'date',
                'end_date' => 'date',
                'total_time' => 'numeric',
                'over_time' => 'numeric',
                'late_mark' => 'nullable|integer',
                'early_mark' => 'nullable|integer',
                'leave_mark' => 'nullable|integer',
                'gov_holiday' => 'nullable|integer',
                'weekly_holiday' => 'nullable|integer',
                'absent' => 'nullable|integer'
            ]
        );

        $authid = Auth::id();

        HrmAttendanceSummary::create(
            [
                'employee_id' => ($request->employee_id == null) ? '' : $request->employee_id,
                'date' => ($request->date == null) ? '' : $request->date,
                'start_date' => ($request->start_date == null) ? '' : $request->start_date,
                'end_date' => ($request->end_date == null) ? '' : $request->end_date,
                'total_time' => ($request->total_time == null) ? '' : $request->total_time,
                'over_time' => ($request->over_time == null) ? '' : $request->over_time,
                'late_mark' => ($request->late_mark == null) ? '' : $request->late_mark,
                'early_mark' => ($request->early_mark == null) ? '' : $request->early_mark,
                'leave_mark' => ($request->leave_mark == null) ? '' : $request->leave_mark,
                'gov_holiday' => ($request->gov_holiday == null) ? '' : $request->gov_holiday,
                'weekly_holiday' => ($request->weekly_holiday == null) ? '' : $request->weekly_holiday,
                'absent' => ($request->absent == null) ? '' : $request->absent,
                'created_by' => $authid
            ]
        );

        return redirect(route('attendancesummary.index'))->with('success', 'Timesheet added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrmAttendanceSummary $HrmAttendanceSummary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmAttendanceSummary $HrmAttendanceSummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $HrmAttendanceSummary)
    {
        $request->validate(
            [
                'start_date' => 'date',
                'end_date' => 'date',
                'total_time' => 'numeric',
                'over_time' => 'numeric',
                'late_mark' => 'nullable|integer',
                'early_mark' => 'nullable|integer',
                'leave_mark' => 'nullable|integer',
                'gov_holiday' => 'nullable|integer',
                'weekly_holiday' => 'nullable|integer',
                'absent' => 'nullable|integer'
            ]
        );

        $authid = Auth::id();

        $attendanceData = HrmAttendanceSummary::find($HrmAttendanceSummary);
        $attendanceData->start_date = $request->start_date;
        $attendanceData->end_date = $request->end_date;
        $attendanceData->total_time = $request->total_time;
        $attendanceData->over_time = $request->over_time;
        $attendanceData->late_mark = $request->late_mark;
        $attendanceData->early_mark = $request->early_mark;
        $attendanceData->leave_mark = $request->leave_mark;
        $attendanceData->gov_holiday = $request->gov_holiday;
        $attendanceData->weekly_holiday = $request->weekly_holiday;
        $attendanceData->absent = $request->absent;
        $attendanceData->created_by = $authid;
        $attendanceData->save();

        return redirect(route('attendancesummary.index'))->with('success', 'Timesheet has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($HrmAttendanceSummary = null)
    {
        $authid = Auth::id();
        $attendanceData = HrmAttendanceSummary::find($HrmAttendanceSummary);
        $attendanceData->deleted_by = $authid;
        $attendanceData->save();
        $attendanceData->delete();

        return redirect(route('attendancesummary.index'))->with('success', 'Timesheet has been deleted successfully');
    }

    // Regenerate Attendance
    public function regenerateAttendanceIndex()
    {
        $menus = Menu::get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name','asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department','asc')->get();
        $designations = Designation::select('id', 'designation')->orderBy('designation','asc')->get();
        $attendanceSummeries = HrmAttendanceSummary::select('hrm_attendance_summary.*', 'mas_employees.emp_name', 'mas_designation.designation', 'tbl_suboffices.name')
            ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_attendance_summary.employee_id')
            ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
            ->leftJoin('tbl_suboffices', 'tbl_suboffices.id', '=', 'mas_employees.suboffice_id')
            ->orderBy('hrm_attendance_summary.date', 'desc')
            ->get();

        return view('pages.hrm.entryForm.regenerateAttendance', compact('menus', 'attendanceSummeries', 'employees', 'suboffices', 'departments', 'designations'));
    }
    
    //Daily Attendance Report
    public function dailyAttendanceReportIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();

        $selectedDate = '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        $hrmAttendances = [];

        return view('pages.hrm.reports.dailyAttendance', compact(
            'menus', 
            'suboffices',  
            'masDepartments', 
            'selectedDate',
            'selectedSuboffice',
            'selectedDepartment',
            'hrmAttendances' 
        ));
    }

    public function dailyAttendanceReportShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();

        $selectedDate = $request->date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $hrmAttendances = HrmAttendanceSummary::select('*')
        ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_attendance_summary.employee_id')
        ->orderBy('mas_employees.id')
        ->where('hrm_attendance_summary.date', $selectedDate);
        if ($selectedSuboffice>-1) {
            $hrmAttendances->where('mas_employees.suboffice_id',$selectedSuboffice);
        }
        if ($selectedDepartment>-1) {
            $hrmAttendances->where('mas_employees.department',$selectedDepartment);
        }
        $hrmAttendances = $hrmAttendances->paginate(20);

        return view('pages.hrm.reports.dailyAttendance', compact(
            'menus', 
            'suboffices',  
            'masDepartments', 
            'selectedDate',
            'selectedSuboffice',
            'selectedDepartment',
            'hrmAttendances' 
        ));
    }

    //Night Allowance Summary
    public function nightAllowanceIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedFromDate= '';
        $selectedToDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        
        $masEmployees = [];

        $selectedOfficeName = '';

        return view('pages.hrm.reports.nightAllowanceReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedFromDate',
            'selectedToDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }

    public function nightAllowanceShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedFromDate = $request->from_date;
        $selectedToDate = $request->to_date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $masEmployees = [];

        $selectedOfficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();

        return view('pages.hrm.reports.nightAllowanceReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedFromDate',
            'selectedToDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }

    //Holiday Allowance Summary
    public function holidayAllowanceIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedFromDate= '';
        $selectedToDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        
        $masEmployees = [];

        $selectedOfficeName = '';

        return view('pages.hrm.reports.holidayAllowanceReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedFromDate',
            'selectedToDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }

    public function holidayAllowanceShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedFromDate = $request->from_date;
        $selectedToDate = $request->to_date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $masEmployees = [];

        $selectedOfficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();

        return view('pages.hrm.reports.holidayAllowanceReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedFromDate',
            'selectedToDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }
}
