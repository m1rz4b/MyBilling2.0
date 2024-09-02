<?php

namespace App\Http\Controllers;

use App\Models\MasEmployee;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $mas_employees =  MasEmployee::select
            (
                'mas_employees.id',
                'mas_employees.emp_name',
                DB::raw("DATE_FORMAT(mas_employees.date_of_birth,'%m/%d/%Y') as date_of_birth"),
                DB::raw("DATE_FORMAT(mas_employees.date_of_joing,'%m/%d/%Y') as date_of_joing"),
                'mas_departments.department as department',
                'mas_designation.designation as designation',
                'mas_employees.address',
                'mas_employees.mobile',
                'mas_employees.email',
                'employee_status.name as statusname'
            )
            ->leftJoin('mas_departments', 'mas_departments.id', '=', 'mas_employees.department_id')
            ->leftJoin('mas_designation', 'mas_designation.id', '=', 'mas_employees.designation_id')
            ->leftJoin('employee_status', 'employee_status.id', '=', 'mas_employees.status')
            ->get();
        return view('pages.hrm.entryForm.employeeInformation', compact('menus', 'mas_employees'));
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

    public function woPin()
    {
        //
        $menus = Menu::where('status',1)->get();
        $wopinemployees = DB::table('mas_employees')
            ->leftjoin('mas_departments', 'mas_employees.department_id', '=', 'mas_departments.id')
            ->leftjoin('mas_designation', 'mas_employees.designation_id', '=', 'mas_designation.id')
            ->select('mas_employees.id', 'mas_employees.emp_name', 'mas_departments.department', 'mas_designation.designation', 'mas_employees.mobile', 'mas_employees.email', 'mas_employees.emp_pin')
            ->where('mas_employees.emp_pin', '=', '')
            ->get();
        // dd($wopinemployees);
        // $wopinemployees = MasEmployee::with('MasDepartment', 'Designation')->get();
        return view('pages.hrm.employeeWoPin', compact('menus', 'wopinemployees'));
    }

    public function woPinUpdate(Request $request, MasEmployee $empwopin)
    {
        //
        $data = $request->validate([
            'emp_name' => 'required',
            'emp_pin' => 'required'
        ]);
        // $emp = MasEmployee::find($empwopin->id);
        $empwopin->update($data);
        // dd($emp);
        return redirect()->route('empwopin.woPin')->with('success', 'The Pin of the employee assigned successfully');
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
    public function update(Request $request, MasEmployee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasEmployee $employee)
    {
        //
    }
}
