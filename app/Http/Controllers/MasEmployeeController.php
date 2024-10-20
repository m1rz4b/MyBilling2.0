<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\EmployeeLeaveLedger;
use App\Models\EmployeeStatus;
use App\Models\EmpPaymentMode;
use App\Models\HrmAttendanceSummary;
use App\Models\HrmSalaryStatus;
use App\Models\LeaveType;
use App\Models\MasBank;
use App\Models\MasDepartment;
use App\Models\MasEmployee;
use App\Models\Menu;
use App\Models\TblHoliday;
use App\Models\TblSchedule;
use App\Models\TblSuboffice;
use App\Models\TblUserType;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\pick;

class MasEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name','asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department','asc')->get();
        $designations = Designation::select('id', 'designation')->orderBy('designation','asc')->get();
        $employee_statuses = EmployeeStatus::select('id','name')->orderBy('name', 'asc')->get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name', 'asc')->get();
        $salary_status = HrmSalaryStatus::select('id', 'description')->orderBy('description', 'asc')->get();
        $mas_banks = MasBank::select('id', 'bank_name')->orderBy('bank_name', 'asc')->get();
        $shifts = TblSchedule::select('id', 'sch_name')->orderBy('sch_name', 'asc')->get();
        $payment_modes = EmpPaymentMode::select('id', 'name')->orderBy('name', 'asc')->get();
        $user_types = TblUserType::select('id', 'type_name')->where('id', '>', '2')->orderBy('type_name', 'asc')->get();
        $mas_employees =  MasEmployee::select
            (
                'mas_employees.id',
                'mas_employees.emp_name',
                DB::raw("DATE_FORMAT(mas_employees.date_of_birth,'%m/%d/%Y') as date_of_birth"),
                DB::raw("DATE_FORMAT(mas_employees.date_of_joining,'%m/%d/%Y') as date_of_joining"),
                'mas_departments.department as department',
                'mas_designation.designation as designation',
                'mas_employees.address',
                'mas_employees.mobile',
                'mas_employees.email',
                'employee_status.name as statusname'
            )
            ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
            ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
            ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status')
            ->get();

        $edit_mas_employees =  MasEmployee::get();
        // dd($edit_mas_employees);

        return view('pages.hrm.entryForm.employeeInformation', compact('menus', 'suboffices', 'departments', 'designations', 'employees', 'employee_statuses', 'salary_status', 'mas_banks', 'shifts', 'payment_modes', 'user_types', 'mas_employees', 'edit_mas_employees'));
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

        $newEmployee = MasEmployee::create([
        'suboffice_id' => ($request->suboffice_id == null) ? '' : $request->suboffice_id,
        'emp_name' => ($request->emp_name == null) ? '' : $request->emp_name,
        'emp_pin' => ($request->emp_pin == null) ? '' : $request->emp_pin,
        'date_of_joining' => ($request->date_of_joining == null) ? '' : $request->date_of_joining,
        'mobile' => ($request->mobile == null) ? '' : $request->mobile,
        'email' => ($request->email == null) ? '' : $request->email,
        'department' => ($request->department == null) ? '' : $request->department,
        'designation' => ($request->designation == null) ? '' : $request->designation,
        'status' => ($request->status == null) ? '' : $request->status,
        'reporting_manager' => ($request->reporting_manager == null) ? '' : $request->reporting_manager,
        'reporting_manager_des' => ($request->reporting_manager_des == null) ? '' : $request->reporting_manager_des,
        'salary_status' => ($request->salary_status == null) ? '' : $request->salary_status,
        'address' => ($request->address == null) ? '' : $request->address,
        'payment_mode' => ($request->payment_mode == null) ? '' : $request->payment_mode,
        'bank_id' => ($request->bank_id == null) ? '' : $request->bank_id,
        'acc_no' => ($request->acc_no == null) ? '' : $request->acc_no,
        'shift_id' => ($request->shift_id == null) ? '' : $request->shift_id,
        'user_group_id' => ($request->user_group_id == null) ? '' : $request->user_group_id,
        'e_tin' => ($request->e_tin == null) ? '' : $request->e_tin,
        'last_increment_date' => ($request->last_increment_date == null) ? '' : $request->last_increment_date,
        'last_promotion_date' => ($request->last_promotion_date == null) ? '' : $request->last_promotion_date,
        'created_by' => $user_id
        ]);

        return redirect(route('employeeinformation.index'))->with('success', 'Employee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasEmployee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasEmployee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $employee)
    {
        $user_id = Auth::id();

        $employee_information = MasEmployee::find($employee);
        $employee_information->suboffice_id = $request->suboffice_id;
        $employee_information->emp_name = $request->emp_name;
        $employee_information->emp_pin = $request->emp_pin;
        $employee_information->date_of_joining = $request->date_of_joining;
        $employee_information->mobile = $request->mobile;
        $employee_information->email = $request->email;
        $employee_information->department = $request->department;
        $employee_information->designation = $request->designation;
        $employee_information->status = $request->status;
        $employee_information->reporting_manager = $request->reporting_manager;
        $employee_information->reporting_manager_des = $request->reporting_manager_des;
        $employee_information->salary_status = $request->salary_status;
        $employee_information->address = $request->address;
        $employee_information->payment_mode = $request->payment_mode;
        $employee_information->bank_id = $request->bank_id;
        $employee_information->acc_no = $request->acc_no;
        $employee_information->shift_id = $request->shift_id;
        $employee_information->user_group_id = $request->user_group_id;
        $employee_information->e_tin = $request->e_tin;
        $employee_information->last_increment_date = $request->last_increment_date;
        $employee_information->last_promotion_date = $request->last_promotion_date;
        $employee_information->updated_by = $user_id;
        $employee_information->save();

        return redirect(route('employeeinformation.index'))->with('success', 'Employee Information has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasEmployee $employee)
    {
        //
    }

    public function woPin()
    {
        $menus = Menu::get();
        $wopinemployees = DB::table('mas_employees')
        ->leftjoin('mas_departments', 'mas_employees.department', '=', 'mas_departments.id')
        ->leftjoin('mas_designation', 'mas_employees.designation', '=', 'mas_designation.id')
        ->select('mas_employees.id', 'mas_employees.emp_name', 'mas_departments.department',
        'mas_designation.designation', 'mas_employees.mobile', 'mas_employees.email', 'mas_employees.emp_pin')
        ->where('mas_employees.emp_pin', '=', '')
        ->get();
        // $wopinemployees = MasEmployee::with('MasDepartment', 'Designation')->get();
        return view('pages.hrm.employeeWoPin', compact('menus', 'wopinemployees'));
    }

    public function woPinUpdate(Request $request, MasEmployee $empwopin)
    {
        $data = $request->validate([
        'emp_name' => 'required',
        'emp_pin' => 'required'
        ]);

        $empwopin->update($data);

        return redirect()->route('empwopin.woPin')->with('success', 'The Pin of the employee assigned successfully');
    }

    // Day Off Entry
    public function dayoffentryIndex()
    {
        $selectedMonth = '';
        $selectedYear = '';
        $selectedEmployee = '';
        $selectedOffice = '';
        $selectedDepartment = '';
        $menus = Menu::get();
        $from_date = '';
        $mas_employees = MasEmployee::select('id', 'emp_name')->orderBy('emp_name', 'asc')->get();
        $offices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $day_off_entries = $employees = MasEmployee::select(
            'mas_employees.id as emp_id',
            'mas_employees.emp_name',
            'mas_employees.emp_no',
            'tbl_day_off.id',
            'tbl_day_off.off_date',
            'mas_departments.department',
            'mas_designation.designation'
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->leftJoin('tbl_day_off', function($join) use ($from_date) {
            $join->on('tbl_day_off.emp_id', '=', 'mas_employees.id')
                ->where('tbl_day_off.off_date', '=', $from_date);
        })
        ->paginate(30);
        // dd($day_off_entries);

        return view('pages.hrm.entryForm.dayOffEntry', compact('menus', 'from_date', 'mas_employees', 'offices', 'departments', 'day_off_entries', 'selectedMonth', 'selectedYear', 'selectedEmployee', 'selectedOffice', 'selectedDepartment'));
    }

    // Leave Register
    public function leaveregisterIndex()
    {
        $selectedYear = '';
        $selectedDepartment = '';
        $selectedEmployee = '';
        $menus = Menu::get();
        $employees_modal = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department','asc')->get();
        $employees =  MasEmployee::select(
            'employee_leave_ledger.id',
            'mas_employees.id as emp_id',
            'mas_employees.emp_name',
            'employee_leave_ledger.year',
            'employee_leave_ledger.leave_type',
            'employee_leave_ledger.allowed',
            'employee_leave_ledger.consumed',
            'employee_leave_ledger.carry',
            'employee_leave_ledger.total',
            'tbl_leavetype.name'
        )
        ->leftJoin('employee_leave_ledger', 'employee_leave_ledger.employee_id', '=', 'mas_employees.id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'employee_leave_ledger.leave_type')
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status')
        ->orderBy('mas_employees.emp_name')
        ->paginate(10);

        return view('pages.hrm.entryForm.leaveRegister', compact('menus', 'employees_modal', 'leave_types', 'departments', 'employees', 'selectedYear', 'selectedDepartment', 'selectedEmployee'));
    }

    public function leaveRegisterStore(Request $request)
    {
        $user_id = Auth::id();

        $newEmployeeLeaveLedger = EmployeeLeaveLedger::create([
            'employee_id' => ($request->employee_id == null) ? '' : $request->employee_id,
            'leave_type' => ($request->leave_type == null) ? '' : $request->leave_type,
            'year' => ($request->year == null) ? '' : $request->year,
            'total' => ($request->total == null) ? '' : $request->total,
            'created_by' => $user_id
        ]);

        return redirect(route('leaveregister.index'))->with('success', 'Leave Register added successfully');
    }

    public function leaveRegisterUpdate(Request $request, $leaveregister)
    {
        $user_id = Auth::id();

        $emp_leave_ledger = EmployeeLeaveLedger::find($leaveregister);
        $emp_leave_ledger->employee_id = $request->employee_id;
        $emp_leave_ledger->leave_type = $request->leave_type;
        $emp_leave_ledger->year = $request->year;
        $emp_leave_ledger->total = $request->total;
        $emp_leave_ledger->updated_by = $user_id;
        $emp_leave_ledger->save();

        return redirect(route('leaveregister.index'))->with('success', 'Leave Register has been updated successfully');
    }

    public function leaveregisterShow(Request $request)
    {
        // dd($request);
        $selectedYear = $request->year;
        $selectedDepartment = $request->department;
        $selectedEmployee = $request->employee;
        $menus = Menu::get();
        $employees_modal = MasEmployee::select('id', 'emp_name')->orderBy('emp_name','asc')->get();
        $leave_types = LeaveType::select('id', 'name')->orderBy('name','asc')->get();
        $departments = MasDepartment::select('id', 'department')->orderBy('department','asc')->get();
        $employees =  MasEmployee::select(
            'employee_leave_ledger.id',
            'mas_employees.id as emp_id',
            'mas_employees.emp_name',
            'employee_leave_ledger.year',
            'employee_leave_ledger.leave_type',
            'employee_leave_ledger.allowed',
            'employee_leave_ledger.consumed',
            'employee_leave_ledger.carry',
            'employee_leave_ledger.total',
            'tbl_leavetype.name'
        )
        ->leftJoin('employee_leave_ledger', 'employee_leave_ledger.employee_id', '=', 'mas_employees.id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'employee_leave_ledger.leave_type')
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status')
        ->orderBy('mas_employees.emp_name');
        if ($selectedYear>-1) {
            $employees->where('employee_leave_ledger.year',$selectedYear);
        }
        if ($selectedDepartment>-1) {
            $employees->where('department',$selectedDepartment);
        }
        if ($selectedEmployee>-1) {
            $employees->where('mas_employees.id',$selectedEmployee);
        }
        $employees = $employees->paginate(10);

        return view('pages.hrm.entryForm.leaveRegister', compact('menus', 'employees_modal', 'leave_types', 'departments', 'employees', 'selectedYear', 'selectedDepartment', 'selectedEmployee'));
    }

    // Import All Data
    public function importDataIndex()
    {
        $menus = Menu::get();

        return view('pages.hrm.entryForm.importAllData', compact('menus'));
    }

    //Employee List Report
    public function employeeListIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();

        $selectedSuboffice = '';
        $selectedEmployeeStatus = '';
        $selectedDepartment = '';
        $selectedDesignation = '';
        $name = '';
                $masEmployees = MasEmployee::select(
            'mas_employees.id as emp_id',
            'mas_employees.emp_name',
            DB::raw("DATE_FORMAT(hrm_emp_personal_details.date_of_birth, '%m/%d/%Y') as date_of_birth"),
            DB::raw("DATE_FORMAT(mas_employees.date_of_joining, '%m/%d/%Y') as date_of_joining"),
            'mas_employees.date_of_joining as ndate',
            'mas_departments.department as department',
            'mas_designation.designation as designation',
            'mas_employees.address',
            'mas_employees.mobile',
            'mas_employees.email',
            'employee_status.name'
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->leftJoin('hrm_emp_personal_details', 'hrm_emp_personal_details.emp_id', '=', 'mas_employees.id')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status')        
        ->paginate(20)->withQueryString();

        $subofficeName = '';
        $employeeStatusName = '';
        $departmentName = '';
        $designationName = '';

        return view('pages.hrm.reports.employeeList', compact(
            'menus', 
            'suboffices', 
            'employeeStatus', 
            'masDepartments', 
            'masDesignations', 
            'selectedSuboffice', 
            'selectedEmployeeStatus', 
            'selectedDepartment', 
            'selectedDesignation',
            'name', 
            'masEmployees',
            'subofficeName',
            'employeeStatusName',
            'departmentName',
            'designationName'
        ));
    }

    public function employeeListShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();

        $selectedSuboffice = $request->suboffice_id;
        $selectedEmployeeStatus = $request->status_id;
        $selectedDepartment = $request->department;
        $selectedDesignation = $request->designation;
        $name = $request->name;
        $masEmployees = MasEmployee::select(
            'mas_employees.id as emp_id',
            'mas_employees.emp_name',
            DB::raw("DATE_FORMAT(hrm_emp_personal_details.date_of_birth, '%m/%d/%Y') as date_of_birth"),
            DB::raw("DATE_FORMAT(mas_employees.date_of_joining, '%m/%d/%Y') as date_of_joining"),
            'mas_employees.date_of_joining as ndate',
            'mas_departments.department as department',
            'mas_designation.designation as designation',
            'mas_employees.address',
            'mas_employees.mobile',
            'mas_employees.email',
            'employee_status.name'
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation')
        ->leftJoin('hrm_emp_personal_details', 'hrm_emp_personal_details.emp_id', '=', 'mas_employees.id')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status');        
        if ($name!='') {
            $masEmployees->where('mas_employees.emp_name', $name);
            $masEmployees->orWhere('mas_employees.address', $name);
            $masEmployees->orWhere('mas_employees.mobile', $name);
        }
        if ($selectedSuboffice>-1) {
            $masEmployees->where('mas_employees.suboffice_id',$selectedSuboffice);
        }
        if ($selectedEmployeeStatus>-1) {
            $masEmployees->where('mas_employees.status',$selectedEmployeeStatus);
        }
        if ($selectedDepartment>-1) {
            $masEmployees->where('mas_employees.department',$selectedDepartment);
        }
        if ($selectedDesignation>-1) {
            $masEmployees->where('mas_employees.designation',$selectedDesignation);
        }
        $masEmployees = $masEmployees->paginate(20)->withQueryString();

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $employeeStatusName = EmployeeStatus::select('id', 'name')->where('id', $selectedEmployeeStatus)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $designationName = Designation::select('id', 'designation')->where('id', $selectedDesignation)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.employeeList', compact(
                'menus', 
                'suboffices', 
                'employeeStatus', 
                'masDepartments', 
                'masDesignations', 
                'selectedSuboffice', 
                'selectedEmployeeStatus', 
                'selectedDepartment', 
                'selectedDesignation',
                'name', 
                'masEmployees',
                'subofficeName',
                'employeeStatusName',
                'departmentName',
                'designationName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.employeeListReport', compact(
                'masEmployees',
                'subofficeName',
                'employeeStatusName',
                'departmentName',
                'designationName'
            ))->setPaper('a4', 'landscape');
            return $pdf->download('invoices.pdf');
        }
    }

    //Performance Report
    public function performanceReportIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();
        $hrmSalaryStatus = HrmSalaryStatus::select('id', 'description')->orderBy('description', 'asc')->get();

        $selectedYear= '';
        $selectedMonth= '';
        $selectedSuboffice = '';
        $selectedEmployeeStatus = '';
        $selectedDepartment = '';
        $selectedDesignation = '';
        $selectedSalaryStatus = '';
        $masEmployees = [];

        return view('pages.hrm.reports.performanceReport', compact(
            'menus', 
            'suboffices', 
            'employeeStatus', 
            'masDepartments', 
            'masDesignations', 
            'hrmSalaryStatus', 
            'selectedYear',
            'selectedMonth',
            'selectedSuboffice', 
            'selectedEmployeeStatus', 
            'selectedDepartment', 
            'selectedDesignation',
            'selectedSalaryStatus',
            'masEmployees' 
        ));
    }

    public function performanceReportShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();
        $hrmSalaryStatus = HrmSalaryStatus::select('id', 'description')->orderBy('description', 'asc')->get();

        $selectedYear= $request->year;
        $selectedMonth= $request->month;
        $d = cal_days_in_month(CAL_GREGORIAN,  $selectedMonth, $selectedYear);
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;
        $selectedEmployeeStatus = $request->status_id;
        $selectedDesignation = $request->designation;
        $selectedSalaryStatus = $request->salary_status;

        $cond=' where 1=1';
        $head='';
        if(isset ($selectedDepartment) != NULL  && $selectedDepartment >= 1){
            $d_name = MasDepartment::where('id', $selectedDepartment)->value('department');
            $head .='Department: '.$d_name;
            if ($cond != NULL) {
                $cond .= " AND mas_employees.department = '" . $selectedDepartment . "'";
            } else {
                $cond = " WHERE mas_employees.department = '" . $selectedDepartment . "'";
            }
        }

        if (isset($selectedSuboffice) != NULL && $selectedSuboffice >= 1) {
            $s_name = TblSuboffice::where('id', $selectedSuboffice)->value('name');
            
            if ($head == '') {
                $head .= ' Office: ' . $s_name;
            } else {
                $head .= ', Office: ' . $s_name;
            }

            if ($cond != NULL) {
                $cond .= " AND mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            } else {
                $cond = " WHERE mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
        }

        if (isset($selectedEmployeeStatus) && $selectedEmployeeStatus >= 1) {
            $s_name = EmployeeStatus::where('id', $selectedEmployeeStatus)->value('name');
            $head .= ', Status: ' . $s_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.status = '" . $selectedEmployeeStatus . "'";
            } else {
                $cond = " WHERE mas_employees.status = '" . $selectedEmployeeStatus . "'";
            }

        } else {
            if ($cond != NULL) {
                $cond .= " AND mas_employees.status in (1,4)";
            } else {
                $cond = " WHERE mas_employees.status in (1,4)";
            }
        }

        if (isset($selectedDesignation) && $selectedDesignation >= 1) {
            $ds_name = Designation::where('id', $selectedDesignation)->value('designation');
            $head .= ', Designation: ' . $ds_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.designation = '" . $selectedDesignation . "'";
            } else {
                $cond = " WHERE mas_employees.designation = '" . $selectedDesignation . "'";
            }
        }

        if (isset($selectedSalaryStatus) && $selectedSalaryStatus >= 1) {
            $sl_name = HrmSalaryStatus::where('id', $selectedSalaryStatus)->value('description');
            $head .= ', Salary Status: ' . $sl_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.salry_status = '" . $selectedSalaryStatus . "'";
            } else {
                $cond = " WHERE mas_employees.salry_status = '" . $selectedSalaryStatus . "'";
            }
        }

        $dbwholy = [];
        $weekendDays = DB::table('tbl_weekend')
                        ->where('weekend', 1)
                        ->pluck('id');

        $b = 1;
        foreach ($weekendDays as $wday) {
            $dbwholy[$b] = $wday;
            $b++;
        }

        $govholy = TblHoliday::whereMonth('holiday_date', $selectedMonth)
            ->whereYear('holiday_date', $selectedYear)
            ->count();

        function countDays($year, $month, $ignore) {
            $count = 0;
            $counter = mktime(0, 0, 0, $month, 1, $year);
            while (date("n", $counter) == $month) {
                if (in_array(date("w", $counter), $ignore) == false) {
                    $count++;
                }
                $counter = strtotime("+1 day", $counter);
            }
            return $count;
        }

        function getweekendDays($year, $month, $ignore) {
            $w_holidays=array();
            $count = 0;
            $counter = mktime(0, 0, 0, $month, 1, $year);
            while (date("n", $counter) == $month) {
                if (in_array(date("w", $counter), $ignore) != false) {
                    $w_holidays[] = date('d',$counter) ;
                    
                    $count++;
                }
                $counter= strtotime("+1 day", $counter);
            }
            return $w_holidays;
        }

        $weekend = [];
        $holidays = [];
        $diffday=countDays($selectedYear,$selectedMonth, $dbwholy);
        $weekend=getweekendDays($selectedYear,$selectedMonth, $dbwholy);

        $holidayDays = DB::table('tbl_holidays')
            ->select(DB::raw('DAY(holiday_date) AS holiday'))
            ->whereMonth('holiday_date', $selectedMonth)
            ->whereYear('holiday_date', $selectedYear)
            ->get();

        $c = 1;
        foreach ($holidayDays as $row) {
            $holidays[$c] = $row->holiday;
            $c++;
        }

        $chw=count(array_intersect($weekend,$holidays));

        $masEmployees = DB::select("
            SELECT
                id,
                emp_name,
                emp_no,
                shift_id,
                department AS depart,
                emp_no
            FROM
                mas_employees
            $cond
        ");

        foreach ($masEmployees as $employees) {
            $tot_precent = 0;
            $tot_leave = 0;
            $tot_late=0;

            $mtext='';
            $emp_id =  $employees->id;
            $emp_no =  $employees->emp_no;

            $attendances = HrmAttendanceSummary::select([
                'id',
                'employee_id',
                'shift_id',
                DB::raw('DAY(date) AS date'),
                'start_date',
                'end_date',
                'total_time',
                'over_time',
                'late_mark',
                'early_mark',
                'leave_mark',
                'leave_type',
                'gov_holiday',
                'weekly_holiday',
                'absent',
                'administrative',
                'entry_by',
                'entry_date',
                'update_by',
                'update_date',
            ])
            ->where('employee_id', $emp_id)
            ->whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->orderBy('employee_id')
            ->orderBy('date', 'ASC')
            ->get();

            $p_date_array = [];
            $p_date = [];
            $p_type_array = [];
            $late_mark_array = [];
            $early_mark_array = [];
            $leave_mark_array = [];
            $leave_type_array = [];
            $gov_holiday_array = [];
            $weekly_holiday_array = [];
            $absent_array = [];
			$y = 1;
			$mtext='';
			$bgcolor='';
			$clr='';
			$l='';

            foreach ($attendances as $attendance) {
                $date = $attendance->date;
                dd($date);
                $p_date[$date] = $date;
                dd($p_date);
                $late_mark_array[$date] = $attendance->late_mark;
                $early_mark_array[$date] = $attendance->early_mark;
                $leave_mark_array[$date] = $attendance->leave_mark;
                $leave_type_array[$date] = $attendance->leave_type;
                $gov_holiday_array[$date] = $attendance->gov_holiday;
                $weekly_holiday_array[$date] = $attendance->weekly_holiday;
                $absent_array[$date] = $attendance->absent;
                $start_time[$date] = strtotime($attendance->start_date);

                $y++;
            }

            $t = 1;
			$u = 1;
			$ta=0;
			$wh=0;
			$gh=0;
			$mtext='';
			$bgcolor='';
			$clr='';
			$l='';

            for ($j=1; $j <=$d ; $j++) {
				$mtext='';
				$bgcolor='';
				$clr='';
				$l='';
				if ($p_date[$t] == $j) {
					if ($leave_mark_array[$t] == "1") {
						$mtext='L';
						$clr = "orange";
						$tot_leave++;
						$bgcolor='style="background:#fff;"';
					}
					elseif ($start_time[$t] >0){
						$mtext='P';
						$clr = "black";
						$tot_precent++;
						$l='';
						$bgcolor='style="background:#fff;"';
						if($late_mark_array[$t]==1 && $early_mark_array[$t]==1){
							$tot_late++;
							$l='<br><b style="color:black; font-size:8px">(LE)</b>';
							}
						elseif($late_mark_array[$t]==1){
							$tot_late++;
							$l='<br><b style="color:black;font-size:8px">(L)</b>';
							}
						elseif($early_mark_array[$t]==1){
						$l='<br><b style="color:black;font-size:8px">(E)</b>';
							}
					}
					
					if($weekly_holiday_array[$t]==1){
						$mtext .='W';
						$clr = "white";
						$bgcolor='style="background:#FF0000;"';
						$wh++;
						}
					if($gov_holiday_array[$t]==1){
						$mtext .='H';
						$clr = "white";
						$bgcolor='style="background:#FF0000;"';
						$gh++;
						}	
					if($absent_array[$t]==1 && $mtext==''){
					$mtext="<span style='color:red;'>A</span>";
					$ta++;
					}		
					$t++;
				}
				echo "<td ".$bgcolor."> <span style='color:".$clr."'>".$mtext.$l."</span></td>";		
			}
        }

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $employeeStatusName = EmployeeStatus::select('id', 'name')->where('id', $selectedEmployeeStatus)->first();
        $designationName = Designation::select('id', 'designation')->where('id', $selectedDesignation)->first();
        $salaryStatusName = HrmSalaryStatus::select('id', 'description')->where('id', $selectedSalaryStatus)->first();

        return view('pages.hrm.reports.performanceReport', compact(
            'menus', 
            'suboffices', 
            'employeeStatus', 
            'masDepartments', 
            'masDesignations',
            'hrmSalaryStatus',
            'selectedYear',
            'selectedMonth', 
            'selectedSuboffice', 
            'selectedEmployeeStatus', 
            'selectedDepartment', 
            'selectedDesignation',
            'selectedSalaryStatus',
            'masEmployees',
            'diffday',
            'govholy',
            'chw',
            'd',
            'tot_precent',
            'tot_leave',
            'ta',
            'tot_late'
        ));
    }

    //Attendance Time Sheet
    public function attendanceTimeSheetIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();
        $hrmSalaryStatus = HrmSalaryStatus::select('id', 'description')->orderBy('description', 'asc')->get();

        $selectedYear= '';
        $selectedMonth= '';
        $selectedSuboffice = '';
        $selectedEmployeeStatus = '';
        $selectedDepartment = '';
        $selectedDesignation = '';
        $selectedSalaryStatus = '';
        $masEmployees = [];

        return view('pages.hrm.reports.attendanceTimeSheet', compact(
            'menus', 
            'suboffices', 
            'employeeStatus', 
            'masDepartments', 
            'masDesignations', 
            'hrmSalaryStatus', 
            'selectedYear',
            'selectedMonth',
            'selectedSuboffice', 
            'selectedEmployeeStatus', 
            'selectedDepartment', 
            'selectedDesignation',
            'selectedSalaryStatus',
            'masEmployees' 
        ));
    }

    public function attendanceTimeSheetShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $employeeStatus = EmployeeStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();
        $hrmSalaryStatus = HrmSalaryStatus::select('id', 'description')->orderBy('description', 'asc')->get();

        $selectedYear= $request->year;
        $selectedMonth= $request->month;
        $d = cal_days_in_month(CAL_GREGORIAN,  $selectedMonth, $selectedYear);
        $selectedSuboffice = $request->suboffice_id;
        $selectedEmployeeStatus = $request->status_id;
        $selectedDepartment = $request->department;
        $selectedDesignation = $request->designation;
        $selectedSalaryStatus = $request->salary_status;
        
        $cond=' where 1=1';
        $head='';
        if(isset ($selectedDepartment) != NULL  && $selectedDepartment >= 1){
            $d_name = MasDepartment::where('id', $selectedDepartment)->value('department');
            $head .='Department: '.$d_name;
            if ($cond != NULL) {
                $cond .= " AND mas_employees.department = '" . $selectedDepartment . "'";
            } else {
                $cond = " WHERE mas_employees.department = '" . $selectedDepartment . "'";
            }
        }

        if (isset($selectedSuboffice) != NULL && $selectedSuboffice >= 1) {
            $s_name = TblSuboffice::where('id', $selectedSuboffice)->value('name');
            
            if ($head == '') {
                $head .= ' Office: ' . $s_name;
            } else {
                $head .= ', Office: ' . $s_name;
            }

            if ($cond != NULL) {
                $cond .= " AND mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            } else {
                $cond = " WHERE mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
        }

        if (isset($selectedEmployeeStatus) && $selectedEmployeeStatus >= 1) {
            $s_name = EmployeeStatus::where('id', $selectedEmployeeStatus)->value('name');
            $head .= ', Status: ' . $s_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.status = '" . $selectedEmployeeStatus . "'";
            } else {
                $cond = " WHERE mas_employees.status = '" . $selectedEmployeeStatus . "'";
            }

        }

        if (isset($selectedDesignation) && $selectedDesignation >= 1) {
            $ds_name = Designation::where('id', $selectedDesignation)->value('designation');
            $head .= ', Designation: ' . $ds_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.designation = '" . $selectedDesignation . "'";
            } else {
                $cond = " WHERE mas_employees.designation = '" . $selectedDesignation . "'";
            }
        }

        if (isset($selectedSalaryStatus) && $selectedSalaryStatus >= 1) {
            $sl_name = HrmSalaryStatus::where('id', $selectedSalaryStatus)->value('description');
            $head .= ', Salary Status: ' . $sl_name;

            if ($cond != NULL) {
                $cond .= " AND mas_employees.salary_status = '" . $selectedSalaryStatus . "'";
            } else {
                $cond = " WHERE mas_employees.salary_status = '" . $selectedSalaryStatus . "'";
            }
        }

        $dbwholy = [];
        $weekendDays = DB::table('tbl_weekend')
                        ->where('weekend', 1)
                        ->pluck('id');

        $b = 1;
        foreach ($weekendDays as $wday) {
            $dbwholy[$b] = $wday;
            $b++;
        }

        $govholy = TblHoliday::whereMonth('holiday_date', $selectedMonth)
            ->whereYear('holiday_date', $selectedYear)
            ->count();

        function countDay($year, $month, $ignore) {
            $count = 0;
            $counter = mktime(0, 0, 0, $month, 1, $year);
            while (date("n", $counter) == $month) {
                if (in_array(date("w", $counter), $ignore) == false) {
                    $count++;
                }
                $counter = strtotime("+1 day", $counter);
            }
            return $count;
        }

        function getweekendDay($year, $month, $ignore) {
            $w_holidays=array();
            $count = 0;
            $counter = mktime(0, 0, 0, $month, 1, $year);
            while (date("n", $counter) == $month) {
                if (in_array(date("w", $counter), $ignore) != false) {
                    $w_holidays[] = date('d',$counter) ;
                    
                    $count++;
                }
                $counter= strtotime("+1 day", $counter);
            }
            return $w_holidays;
        }

        $weekend = [];
        $holidays = [];
        $diffday=countDay($selectedYear,$selectedMonth, $dbwholy);
        $weekend=getweekendDay($selectedYear,$selectedMonth, $dbwholy);

        $holidayRecords = TblHoliday::selectRaw('DAY(holiday_date) AS holiday')
            ->whereMonth('holiday_date', $selectedMonth)
            ->whereYear('holiday_date', $selectedYear)
            ->get();

        $c = 1;
        foreach ($holidayRecords as $holidayRecord) {
            $holidays[$c] = $holidayRecord->holiday;
            $c++;
        }

        $masEmployees = DB::select("
            SELECT
                id,
                emp_name,
                emp_no,
                shift_id,
                department AS depart,
                emp_no
            FROM
                mas_employees
            $cond
        ");

        return view('pages.hrm.reports.attendanceTimeSheet', compact(
            'menus', 
            'suboffices', 
            'employeeStatus', 
            'masDepartments', 
            'masDesignations',
            'hrmSalaryStatus',
            'selectedYear',
            'selectedMonth', 
            'selectedSuboffice', 
            'selectedEmployeeStatus', 
            'selectedDepartment', 
            'selectedDesignation',
            'selectedSalaryStatus',
            'masEmployees',
            'd',
            // 'r_month'
        ));
    }

    //Late In Report
    public function lateInIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        
        $masEmployees = [];

        return view('pages.hrm.reports.lateInReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees'
        ));
    }

    public function lateInShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate= $request->date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $cond = "";
        if ($selectedDate != "")
        {
            $cond = "WHERE checkinout.checktime > '$selectedDate 00:00:00' AND  checkinout.checktime < '$selectedDate 23:59:59' and mas_employees.status in (1,4)";
        }

        $head = '';
        $econd = '';
        if ($selectedDepartment >= 1)
        {
            $d_name = DB::table('mas_departments')
                ->where('id', $selectedDepartment)
                ->value('department');
            $head = 'Department: ' . $d_name;
            if ($econd != NULL)
            {
                $econd.= " And mas_employees.department = '" . $selectedDepartment . "'";
            }
            else
            {
                $econd = " where mas_employees.department = '" . $selectedDepartment . "'";
            }
        }

        if ($selectedSuboffice >= 1)
        {
            $s_name = DB::table('tbl_suboffices')
                ->where('id', $selectedSuboffice)
                ->value('name');

            if ($head == '')
            {
                $head = 'Office: ' . $s_name;
            }
            else
            {
                $head.= ', Office: ' . $s_name;
            }

            if ($econd != NULL)
            {
                $econd.= " And mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
            else
            {
                $econd = " where mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
        }

        $perPage = 30;  // Define the number of results per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();  // Get the current page or default to 1
        $offset = ($currentPage + 1) * $perPage;  // Calculate the offset (start position)

        $masEmployees = DB::select("
            SELECT
                mas_employees.id,
                mas_employees.emp_name,
                mas_employees.shift_id,
                mas_employees.emp_no,            
                (
                    SELECT MAX(CAST(checkinout.checktime AS CHAR))
                    FROM checkinout
                    $cond
                    AND mas_employees.emp_no = checkinout.userid
                ) AS checkout,
                (
                    SELECT MIN(CAST(checkinout.checktime AS CHAR))
                    FROM checkinout
                    $cond
                    AND mas_employees.emp_no = checkinout.userid
                ) AS checkin,
                (
                    SELECT dates
                    FROM tbl_leave_details
                    WHERE tbl_leave_details.dates = '$selectedDate 00:00:00'
                    AND mas_employees.id = tbl_leave_details.emp_id
                ) AS lea
            FROM mas_employees
            $econd
            LIMIT :limit OFFSET :offset",[
            'limit' => $perPage,
            'offset' => $offset
        ]);

        $total = DB::table('mas_employees')->count();

        $paginator = new LengthAwarePaginator($masEmployees, $total, $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        // $masEmployees = MasEmployee::select(
        //     'mas_employees.id',
        //     'mas_employees.emp_name',
        //     'mas_employees.shift_id',
        //     'mas_employees.emp_no',
        //     DB::raw("(SELECT MAX(cast(checkinout.checktime AS CHAR)) 
        //             FROM checkinout 
        //             WHERE checkinout.checktime > '$selectedDate 00:00:00' 
        //                 AND checkinout.checktime < '$selectedDate 23:59:59' 
        //                 AND mas_employees.status IN (1, 4) 
        //                 AND mas_employees.emp_no = checkinout.userid
        //             ) as checkout"),
        //     DB::raw("(SELECT MIN(cast(checkinout.checktime AS CHAR)) 
        //             FROM checkinout 
        //             WHERE checkinout.checktime > '$selectedDate 00:00:00' 
        //                 AND checkinout.checktime < '$selectedDate 23:59:59' 
        //                 AND mas_employees.status IN (1, 4) 
        //                 AND mas_employees.emp_no = checkinout.userid
        //             ) as checkin"),
        //     DB::raw("(SELECT tbl_leave_details.dates 
        //             FROM tbl_leave_details 
        //             WHERE tbl_leave_details.dates = '$selectedDate 00:00:00' 
        //                 AND mas_employees.id = tbl_leave_details.emp_id
        //             ) as lea")
        // );
        // if ($selectedSuboffice>-1) {
        //     $masEmployees->where('mas_employees.suboffice_id',$selectedSuboffice);
        // }
        // if ($selectedDepartment>-1) {
        //     $masEmployees->where('mas_employees.department',$selectedDepartment);
        // }
        // $masEmployees = $masEmployees->get();

        // dd($masEmployees);

        foreach ($masEmployees as $employee) {
            $early_time = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('out_start');

            $late_time = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('late_time');

            $end_time = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('end_time');

            $earlyout_time = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('out_start');

            $begining_start = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('begining_start');

            $begining_end = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('begining_end');

            $start_tt = DB::table('tbl_schedule')
                ->where('id', $employee->shift_id)
                ->value('start_time');

            $max = $employee->checkout;
            $max1 = explode(" ", $max);
            $eout_time= date('H:i ', strtotime($earlyout_time));
            $end_time=date('H:i ', strtotime($end_time));
            $begining_start=date('H:i ', strtotime($begining_start));
            
            $min = $employee->checkin;
            $min1 = explode(" ", $min);
            $min = date('g:i a', strtotime($min1[1]));
            // if (isset($min1[1])) {
            //     $min = date('g:i a', strtotime($min1[1]));
            // } else {
            //     $min = 'Invalid time value';
            // }
            // dd($min);
            $l = '';
            $e = '';
            $maxd = '';
            $ld_flag=0;

            if ($employee->checkin != NULL){
                $l_time = date('H:i', strtotime($late_time));
                $begining_end = date('H:i', strtotime($begining_end));
                if (date('H:i', strtotime($min)) < $begining_end && $l_time < date('H:i', strtotime($min) ) ){
                    $mind = date('g:i a', strtotime($min1[1]));
                    $s_tt=date('H:i', strtotime($start_tt));
                    $l = '<span class="bg-danger rounded-1" style="padding: .2em .6em .3em;">Late In</span>';
                    $ld_flag=1;
                }
            }
            else{
                $ab_flag=1;
                $mind = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Absent</span>';
            }
        }

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.lateInReport', compact(
                'menus', 
                'suboffices', 
                'masDepartments', 
                'selectedDate',
                'selectedSuboffice', 
                'selectedDepartment', 
                'masEmployees',
                'subofficeName',
                'departmentName',
                'ld_flag',
                'l',
                'mind',
                'paginator'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.lateInReport', compact(
                'masEmployees',
                'selectedDate',
                'subofficeName',
                'departmentName',
                'ld_flag',
                'l',
                'mind',
                'paginator'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }
    }

    //Absent Report
    public function absentIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        
        $masEmployees = [];

        $selectedOfficeName = '';

        return view('pages.hrm.reports.absentReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }

    public function absentShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate = $request->date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $cond = "";
        if ($selectedDate != "")
        {
            $cond = "WHERE checkinout.checktime > '$selectedDate 00:00:00' AND  checkinout.checktime < '$selectedDate 23:59:59' and mas_employees.status in (1,4)";
        }

        $head = '';
        $econd = '';
        if ($selectedDepartment >= 1)
        {
            $d_name = DB::table('mas_departments')
                ->where('id', $selectedDepartment)
                ->value('department');
            $head = 'Department: ' . $d_name;
            if ($econd != NULL)
            {
                $econd.= " And mas_employees.department = '" . $selectedDepartment . "'";
            }
            else
            {
                $econd = " where mas_employees.department = '" . $selectedDepartment . "'";
            }
        }

        if ($selectedSuboffice >= 1)
        {
            $s_name = DB::table('tbl_suboffices')
                ->where('id', $selectedSuboffice)
                ->value('name');
            if ($head == '')
            {
                $head = 'Office: ' . $s_name;
            }
            else
            {
                $head.= ', Office: ' . $s_name;
            }

            if ($econd != NULL)
            {
                $econd.= " And mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
            else
            {
                $econd = " where mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
        }

        $perPage = 30;  // Define the number of results per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();  // Get the current page or default to 1
        $offset = ($currentPage + 1) * $perPage;  // Calculate the offset (start position)

        $masEmployees = DB::select("
            SELECT
                mas_employees.id,
                mas_employees.emp_name,
                mas_employees.shift_id,
                mas_employees.emp_no,
                (
                    SELECT MAX(CAST(checkinout.checktime AS CHAR)) 
                    FROM checkinout 
                    $cond
                    AND mas_employees.id = checkinout.userid
                ) AS checkout,
                (
                    SELECT MIN(CAST(checkinout.checktime AS CHAR)) 
                    FROM checkinout 
                    $cond
                    AND mas_employees.id = checkinout.userid
                ) AS checkin,
                (
                    SELECT dates 
                    FROM tbl_leave_details 
                    WHERE tbl_leave_details.dates = '$selectedDate 00:00:00' 
                    AND mas_employees.id = tbl_leave_details.emp_id
                ) AS lea

            FROM
                mas_employees
            $econd
            LIMIT :limit OFFSET :offset",[
            'limit' => $perPage,
            'offset' => $offset
        ]);

        $total = DB::table('mas_employees')->count();

        $paginator = new LengthAwarePaginator($masEmployees, $total, $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        foreach ($masEmployees as $employee) {
            if ($employee->lea == NULL){
                $early_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('out_start');

                $late_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('late_time');

                $end_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('end_time');

                $earlyout_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('out_start');

                $begining_start = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('begining_start');

                $begining_end = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('begining_end');

                $start_tt = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('start_time');

                $max = $employee->checkout;
                $max1 = explode(" ", $max);
                $eout_time= date('H:i ', strtotime($earlyout_time));
                $end_time=date('H:i ', strtotime($end_time));
                $begining_start=date('H:i ', strtotime($begining_start));
                
                $min = $employee->checkin;
                $min1 = explode(" ", $min);
                $min = date('g:i a', strtotime($min1[1]));
                // if (isset($min1[1])) {
                //     $min = date('g:i a', strtotime($min1[1]));
                // } else {
                //     $min = 'Invalid time value';
                // }
                // dd($min);
                $l = '';
                $e = '';
                $maxd = '';
                $ab_flag=0;

                if ($employee->checkout != NULL)
                {
                    if ($employee->checkout == $employee->checkin || $employee->checkout == '')
                    {
                        if ($selectedDate == date("Y-m-d"))
                        {
                            $maxd = '';
                        }
                        else
                        {
                            $maxd = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Not Check Out </span>';
                        }
				    }
                    elseif(date('H:i', strtotime($max)) < $eout_time)
                    {
                        $maxd = date('g:i a', strtotime($max1[1]));
                        $e ='<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Absent</span>';
                    }
                    else
				    {
				        $maxd = date('g:i a', strtotime($max1[1]));
				        $e_time = date('H:i ', strtotime($early_time));
                        if (date('H:i', strtotime($max)) < $end_time && date('H:i', strtotime($max)) > $eout_time)
                        {
                            $e = '<span class="bg-danger rounded-1">Early Out</span>';
                        }
				    }
                }
                else
                {
                    $maxd = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Not Check Out </span>';
                }

                if ($employee->checkin != NULL)
			    {
                    $l_time = date('H:i', strtotime($late_time));
                    $begining_end = date('H:i', strtotime($begining_end));
                    if (date('H:i', strtotime($min)) < $begining_end && $l_time < date('H:i', strtotime($min) ) )
                    {
                        $mind = date('g:i a', strtotime($min1[1]));
                        $s_tt=date('H:i', strtotime($start_tt));
                        $l = '<span class="bg-danger rounded-1" style="padding: .2em .6em .3em;">Late In</span>';
                    }
                    elseif((date('H:i', strtotime($min)) > $begining_end && $begining_start > date('H:i', strtotime($min))) ||  (date('H:i', strtotime($min)) > $begining_end))
                    {
                        $mind = date('g:i a', strtotime($min1[1]));
                        $ab_flag=1;
                        $l = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Absent</span>';
                        $ab_flag=1;
                    }
                    else
                    {
                        $mind = date('g:i a', strtotime($min1[1]));	
                    }
                }
                else
                {
                    $ab_flag=1;
                    $mind = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Absent</span>';
                }
            }
            else
            {
                $mind = '<span class="bg-primary rounded-1" style="padding: .2em .6em .3em;">Leave</span>';
            }
        }

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.absentReport', compact(
                'menus', 
                'suboffices', 
                'masDepartments', 
                'selectedDate',
                'selectedSuboffice', 
                'selectedDepartment', 
                'masEmployees',
                'subofficeName',
                'departmentName',
                'ab_flag',
                'l',
                'mind',
                'paginator'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.absentReport', compact(
                'masEmployees',
                'selectedDate',
                'subofficeName',
                'departmentName',
                'ab_flag',
                'l',
                'mind',
                'paginator'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }
    }

    //Early Out Report
    public function earlyOutIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        
        $masEmployees = [];

        $selectedOfficeName = '';

        return view('pages.hrm.reports.earlyOutReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'selectedDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'masEmployees',
            'selectedOfficeName'
        ));
    }

    public function earlyOutShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();

        $selectedDate = $request->date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;

        $cond = "";
        if ($selectedDate != "")
        {
            $cond = "WHERE checkinout.checktime > '$selectedDate 00:00:00' AND  checkinout.checktime < '$selectedDate 23:59:59' and mas_employees.status in (1,4)";
        }

        $head = '';
        $econd = '';
        if ($selectedDepartment >= 1)
        {
            $d_name = DB::table('mas_departments')
                ->where('id', $selectedDepartment)
                ->value('department');

            // dd($d_name);
            $head = 'Department: ' . $d_name;
            if ($econd != NULL)
            {
                $econd.= " And mas_employees.department = '" . $selectedDepartment . "'";
            }
            else
            {
                $econd = " where mas_employees.department = '" . $selectedDepartment . "'";
            }
        }

        if ($selectedSuboffice >= 1)
        {
            $s_name = DB::table('tbl_suboffices')
                ->where('id', $selectedSuboffice)
                ->value('name');
            // dd($s_name);
                
            if ($head == '')
            {
                $head = 'Office: ' . $s_name;
            }
            else
            {
                $head.= ', Office: ' . $s_name;
            }

            if ($econd != NULL)
            {
                $econd.= " And mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
            else
            {
                $econd = " where mas_employees.suboffice_id = '" . $selectedSuboffice . "'";
            }
        }

        $perPage = 30;  // Define the number of results per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();  // Get the current page or default to 1
        $offset = ($currentPage + 1) * $perPage;  // Calculate the offset (start position)

        $masEmployees = DB::select("
            SELECT
                mas_employees.id,
                mas_employees.emp_name,
                mas_employees.shift_id,
                mas_employees.emp_no,
                (
                    SELECT MAX(CAST(checkinout.checktime AS CHAR)) 
                    FROM checkinout 
                    $cond
                    AND mas_employees.emp_no = checkinout.userid 
                ) AS checkout,
                (
                    SELECT MIN(CAST(checkinout.checktime AS CHAR)) 
                    FROM checkinout 
                    $cond
                    AND mas_employees.emp_no = checkinout.userid
                ) AS checkin,
                (
                    SELECT dates 
                    FROM tbl_leave_details 
                    WHERE tbl_leave_details.dates = '$selectedDate 00:00:00' 
                    AND mas_employees.id = tbl_leave_details.emp_id
                ) AS lea

            FROM
                mas_employees
            $econd
            $econd
            LIMIT :limit OFFSET :offset",[
            'limit' => $perPage,
            'offset' => $offset
        ]);

        $total = DB::table('mas_employees')->count();

        $paginator = new LengthAwarePaginator($masEmployees, $total, $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        foreach ($masEmployees as $employee) {
            if ($employee->lea == NULL){
                $early_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('out_start');

                $late_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('late_time');

                $end_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('end_time');

                $earlyout_time = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('out_start');

                $begining_start = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('begining_start');

                $begining_end = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('begining_end');

                $start_tt = DB::table('tbl_schedule')
                    ->where('id', $employee->shift_id)
                    ->value('start_time');
                    
                $max = $employee->checkout;
                $max1 = explode(" ", $max);
                $eout_time= date('H:i ', strtotime($earlyout_time));
                $end_time=date('H:i ', strtotime($end_time));
                $begining_start=date('H:i ', strtotime($begining_start));

                $min = $employee->checkin;
                $min1 = explode(" ", $min);
                $min = date('g:i a', strtotime($min1[1]));
                // if (isset($min1[1])) {
                //     $min = date('g:i a', strtotime($min1[1]));
                // } else {
                //     $min = 'Invalid time value';
                // }
                // dd($min);
                $l = '';
                $e = '';
                $maxd = '';
                $ld_flag=0;

                if ($employee->checkout != NULL)
                {
                    if ($employee->checkout == $employee->checkin || $employee->checkout == '')
                    {
                        if ($selectedDate == date("Y-m-d"))
                        {
                            $maxd = '';
                        }
                        else
                        {
                            $maxd = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Not Check Out </span>';
                        }
				    }
                    else
				    {
				        $maxd = date('g:i a', strtotime($max1[1]));
				        $e_time = date('H:i ', strtotime($early_time));
                        if (date('H:i', strtotime($max)) < $end_time && date('H:i', strtotime($max)) > $eout_time)
                        {
                            $e = '<span class="bg-danger rounded-1" style="padding: .2em .6em .3em;">Early Out</span>';
                            $ld_flag=1;
                        }
				    }
                }

                else
                {
                    $maxd = '<span class="bg-warning rounded-1" style="padding: .2em .6em .3em;">Not Check Out </span>';
                }
            }
            else
            {
                $mind = '<span class="bg-primary rounded-1" style="padding: .2em .6em .3em;">Leave</span>';
            }
        }

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.earlyOutReport', compact(
                'menus', 
                'suboffices', 
                'masDepartments', 
                'selectedDate',
                'selectedSuboffice', 
                'selectedDepartment', 
                'masEmployees',
                'subofficeName',
                'departmentName',
                'ld_flag',
                'e',
                'maxd',
                'paginator'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.earlyOutReport', compact(
                'masEmployees',
                'selectedDate',
                'subofficeName',
                'departmentName',
                'ld_flag',
                'e',
                'maxd',
                'paginator'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }
    }

    //Provision Report
    public function provisionReportIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();

        $selectedMonth= '';
        $selectedYear= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        $selectedDesignation = '';
        $name = '';
        $masEmployees = [];

        return view('pages.hrm.reports.provisionReport', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'masDesignations',
            'selectedMonth',
            'selectedYear',
            'selectedSuboffice', 
            'selectedDepartment', 
            'selectedDesignation',
            'name',
            'masEmployees'
        ));
    }

    public function provisionReportShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('name', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('department', 'asc')->get();
        $masDesignations = Designation::select('id', 'designation')->orderBy('designation', 'asc')->get();

        $selectedMonth= $request->month;
        $selectedYear= $request->year;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;
        $selectedDesignation = $request->designation;
        $name = $request->name;

        if ($selectedMonth == -1 && $selectedYear == -1) {
            $tdate = null;
        } else {
            $d = new DateTime("$selectedYear-$selectedMonth-01");
            $tdate = $d->format('Y-m');
        }

        $masEmployees = MasEmployee::select(
            'mas_employees.id',
            'mas_employees.emp_name',
            'mas_employees.emp_no',
            DB::raw("DATE_FORMAT(mas_employees.date_of_birth, '%d/%m/%Y') as date_of_birth"),
            DB::raw("DATE_FORMAT(mas_employees.date_of_joining, '%d/%m/%Y') as date_of_joining"),
            'mas_departments.department as department',
            'mas_designation.designation as designation',
            'mas_employees.address',
            'mas_employees.mobile',
            'mas_employees.email',
            DB::raw("DATE_FORMAT(mas_employees.provision_days, '%M %Y') as provision_days")
        )
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation');
        if ($selectedMonth>-1 && $selectedYear>-1) {
             $masEmployees->where(DB::raw("DATE_FORMAT(mas_employees.provision_days, '%Y-%m')"), '=', $tdate);
        }
        if ($selectedSuboffice>-1) {
            $masEmployees->where('mas_employees.suboffice_id',$selectedSuboffice);
        }
        if ($selectedDepartment>-1) {
            $masEmployees->where('mas_employees.department',$selectedDepartment);
        }
        if ($selectedDesignation>-1) {
            $masEmployees->where('mas_employees.designation',$selectedDesignation);
        }
        if ($name!='') {
            $masEmployees->where('mas_employees.emp_name', $name);
            $masEmployees->orWhere('mas_employees.address', $name);
            $masEmployees->orWhere('mas_employees.mobile', $name);
        }
        $masEmployees = $masEmployees->paginate(30)->withQueryString();

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $designationName = Designation::select('id', 'designation')->where('id', $selectedDesignation)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.provisionReport', compact(
                'menus', 
                'suboffices', 
                'masDepartments', 
                'masDesignations',
                'selectedMonth',
                'selectedYear',
                'selectedSuboffice', 
                'selectedDepartment', 
                'selectedDesignation',
                'name',
                'masEmployees',
                'subofficeName',
                'departmentName',
                'designationName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.provisionReport', compact(
                'masEmployees',
                'subofficeName',
                'departmentName',
                'designationName'
            ))->setPaper('a4', 'landscape');
            return $pdf->download('invoices.pdf');
        }
    }

    //Raw Check In Out
    public function rawCheckInOutIndex()
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

        $selectedFromDate= '';
        $selectedToDate= '';
        $selectedSuboffice = '';
        $selectedDepartment = '';
        $selectedEmployee = '';
        
        $masEmployees = [];

        return view('pages.hrm.reports.rawCheckInOut', compact(
            'menus', 
            'suboffices', 
            'masDepartments', 
            'employees', 
            'selectedFromDate',
            'selectedToDate',
            'selectedSuboffice', 
            'selectedDepartment', 
            'selectedEmployee',
            'masEmployees'
        ));
    }

    public function rawCheckInOutShow(Request $request)
    {
        $menus = Menu::get();

        $suboffices = TblSuboffice::select('id', 'name')->orderBy('id', 'asc')->get();
        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

        $selectedFromDate = $request->from_date;
        $selectedToDate = $request->to_date;
        $selectedSuboffice = $request->suboffice_id;
        $selectedDepartment = $request->department;
        $selectedEmployee = $request->employee;

        $masEmployees = MasEmployee::leftJoin('checkinout', 'checkinout.userid', '=', 'mas_employees.id')  //Previously it was: 'mas_employees.emp_no'
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department')
        ->select(
            'mas_employees.id',
            'mas_employees.emp_name',
            'mas_employees.shift_id',
            'mas_employees.emp_no',
            'mas_departments.department',
            DB::raw("DATE_FORMAT(checkinout.checktime, '%Y-%m-%d %h:%i %p') as checktime")
        )
        ->orderByDesc('checkinout.checktime')
        ->where('checkinout.checktime', '>=', $selectedFromDate.' 00:00:00')
        ->where('checkinout.checktime', '<=', $selectedToDate. ' 23:59:59');
        if ($selectedSuboffice > -1) {
        $masEmployees->where('mas_employees.suboffice_id', $selectedSuboffice);
        }
        if ($selectedDepartment > -1) {
        $masEmployees->where('mas_employees.department', $selectedDepartment);
        }
        if ($selectedEmployee > -1) {
        $masEmployees->where('mas_employees.id', $selectedEmployee);
        }
        $masEmployees = $masEmployees->paginate(30)->withQueryString();

        $subofficeName = TblSuboffice::select('id', 'name')->where('id', $selectedSuboffice)->first();
        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $employeeName = MasEmployee::select('id', 'emp_name')->where('id', $selectedEmployee)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.rawCheckInOut', compact(
                'menus', 
                'suboffices', 
                'masDepartments',
                'employees', 
                'selectedFromDate',
                'selectedToDate',
                'selectedSuboffice', 
                'selectedDepartment', 
                'selectedEmployee',
                'masEmployees',
                'subofficeName',
                'departmentName',
                'employeeName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.rawCheckInOutReport', compact(
                'masEmployees',
                'selectedFromDate',
                'subofficeName',
                'departmentName',
                'employeeName'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }
        
    }

    //Leave register
    public function leaveRegisterReportIndex()
    {
        $menus = Menu::get();

        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

        $selectedYear= '';
        $selectedDepartment = '';
        $selectedEmployee = '';
        
        $masEmployees = MasEmployee::leftJoin('employee_leave_ledger', 'employee_leave_ledger.employee_id', '=', 'mas_employees.id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'employee_leave_ledger.leave_type')
        ->select(
            'mas_employees.id',
            'mas_employees.emp_name',
            'employee_leave_ledger.year',
            'employee_leave_ledger.leave_type',
            'employee_leave_ledger.allowed',
            'employee_leave_ledger.consumed',
            'employee_leave_ledger.carry',
            'employee_leave_ledger.total',
            'tbl_leavetype.name'
        )
        ->paginate(30);

        $departmentName = '';
        $employeenName = '';

        return view('pages.hrm.reports.leaveRegister', compact(
            'menus', 
            'masDepartments', 
            'employees',
            'selectedYear',
            'selectedDepartment', 
            'selectedEmployee',
            'masEmployees',
            'departmentName',
            'employeenName'
        ));
    }

    public function leaveRegisterReportShow(Request $request)
    {
        $menus = Menu::get();

        $masDepartments = MasDepartment::select('id', 'department')->orderBy('id', 'asc')->get();
        $employees = MasEmployee::select('id', 'emp_name')->orderBy('id', 'asc')->get();

        $selectedYear = $request->year;
        $selectedDepartment = $request->department;
        $selectedEmployee = $request->employee;

        $masEmployees = MasEmployee::leftJoin('employee_leave_ledger', 'employee_leave_ledger.employee_id', '=', 'mas_employees.id')
        ->leftJoin('tbl_leavetype', 'tbl_leavetype.id', '=', 'employee_leave_ledger.leave_type')
        ->select(
            'mas_employees.id',
            'mas_employees.emp_name',
            'employee_leave_ledger.year',
            'employee_leave_ledger.leave_type',
            'employee_leave_ledger.allowed',
            'employee_leave_ledger.consumed',
            'employee_leave_ledger.carry',
            'employee_leave_ledger.total',
            'tbl_leavetype.name'
        );
        if ($selectedYear>-1) {
             $masEmployees->where('employee_leave_ledger.year', $selectedYear);
        }
        if ($selectedDepartment>-1) {
            $masEmployees->where('mas_employees.department',$selectedDepartment);
        }
        if ($selectedEmployee>-1) {
            $masEmployees->where('mas_employees.id',$selectedEmployee);
        }
        $masEmployees = $masEmployees->paginate(30)->withQueryString();

        $departmentName = MasDepartment::select('id', 'department')->where('id', $selectedDepartment)->first();
        $employeenName = MasEmployee::select('id', 'emp_name')->where('id', $selectedEmployee)->first();

        if($request->action == 'show'){
            return view('pages.hrm.reports.leaveRegister', compact(
                'menus', 
                'masDepartments', 
                'employees',
                'selectedYear',
                'selectedDepartment', 
                'selectedEmployee',
                'masEmployees',
                'departmentName',
                'employeenName'
            ));
        }else if($request->action == 'pdf'){
            $pdf = Pdf::loadView('pages.pdf.reports.leaveRegisterReport', compact(
                'selectedYear',
                'masEmployees',
                'departmentName',
                'employeenName'
            ))->setPaper('a4', 'potrait');
            return $pdf->download('invoices.pdf');
        }
        
    }
}