<?php

namespace App\Http\Controllers;

use App\Models\HrmIncrement;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MasDepartment;
use App\Models\MasEmployee;
use App\Models\HrmIncrementType;

class HrmIncrementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();

        $hrm_increments = HrmIncrement::select(
            'hrm_increments.id',
            'hrm_increments.emp_id',
            'hrm_increments.month',
            'hrm_increments.year',
            'hrm_increments.previous_gross',
            'hrm_increments.increment_percent',
            'hrm_increments.increment_amount',
            'hrm_increments.current_gross',
            'hrm_increments.increment_type',
            'mas_employees.department_id',
            'hrm_increments.entry_date'
        )
            ->leftJoin('mas_employees', 'mas_employees.id', '=', 'hrm_increments.emp_id')
            ->leftJoin('hrm_increment_types', 'hrm_increment_types.id', '=', 'hrm_increments.increment_type')
            ->get();

        // $res = mysql_query("SELECT
        // 				  hrm_increment.`id`,
        // 				  hrm_increment.`emp_id`,
        // 				  hrm_increment.`month`,
        // 				  hrm_increment.`year`,
        // 				  hrm_increment.`previous_gross`,
        // 				  hrm_increment.`increment_percent`,
        // 				  hrm_increment.`increment_amount`,
        // 				  hrm_increment.`current_gross`,
        // 				  mas_employees.emp_name,
        // 				  hrm_increment_type.name
        // 				FROM
        // 				  `hrm_increment`
        // 				 LEFT JOIN mas_employees ON mas_employees.emp_id = hrm_increment.emp_id
        // 				 left join hrm_increment_type on hrm_increment_type.id= hrm_increment.increment_type
        // 				WHERE hrm_increment.year = '$year' AND hrm_increment.month = '$month' and `approve_status`=0
        // 				");



        $mas_departments = MasDepartment::select('id', 'department')->orderBy('department', 'desc')->get();
        $mas_employees = MasEmployee::select('id', 'emp_name')->get();
        $hrm_increment_types = HrmIncrementType::select('id', 'name')->orderBy('name', 'desc')->get();
        return view('pages.hrm.entryForm.hrmIncrement', compact('menus', 'hrm_increments', 'mas_departments', 'mas_employees', 'hrm_increment_types'));
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
    public function show(HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmIncrement $hrmIncrement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmIncrement $hrmIncrement)
    {
        //
    }
}
