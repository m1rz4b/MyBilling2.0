<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\EmployeeLeaveLedger;
use App\Models\EmployeeStatus;
use App\Models\EmpPaymentMode;
use App\Models\HrmSalaryStatus;
use App\Models\LeaveType;
use App\Models\MasBank;
use App\Models\MasDepartment;
use App\Models\MasEmployee;
use App\Models\Menu;
use App\Models\TblSchedule;
use App\Models\TblSuboffice;
use App\Models\TblUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department_id')
            ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation_id')
            ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.emp_status_id')
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
        'department_id' => ($request->department_id == null) ? '' : $request->department_id,
        'designation_id' => ($request->designation_id == null) ? '' : $request->designation_id,
        'emp_status_id' => ($request->emp_status_id == null) ? '' : $request->emp_status_id,
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
        $employee_information->department_id = $request->department_id;
        $employee_information->designation_id = $request->designation_id;
        $employee_information->emp_status_id = $request->emp_status_id;
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
        ->leftjoin('mas_departments', 'mas_employees.department_id', '=', 'mas_departments.id')
        ->leftjoin('mas_designation', 'mas_employees.designation_id', '=', 'mas_designation.id')
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
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department_id')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation_id')
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
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department_id')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation_id')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.emp_status_id')
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
        ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department_id')
        ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation_id')
        ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.emp_status_id')
        ->orderBy('mas_employees.emp_name');
        if ($selectedYear>-1) {
            $employees->where('employee_leave_ledger.year',$selectedYear);
        }
        if ($selectedDepartment>-1) {
            $employees->where('department_id',$selectedDepartment);
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
}
