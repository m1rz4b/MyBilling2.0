<?php

namespace App\Http\Controllers;

use App\Models\EmpPaymentMode;
use App\Models\HrmEmpMonthlyAdd;
use App\Models\HrmEmpMonthlySalary;
use App\Models\HrmEmpMonthlySalaryTemp;
use App\Models\MasDepartment;
use App\Models\Menu;
use DB;
use Illuminate\Http\Request;

class HrmEmpMonthlySalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    public function empsalarytemp()
    {
        //
        $menus = Menu::get();
        $salarytemps = [];
        $selectedYear = '';
        $selectedMonth = '';
        $selectedDepartment = '';
        $selectedPaymentMode = '';
        $departments = MasDepartment::get();
        $paymentmodes = EmpPaymentMode::get();
        
        return view('pages.hrm.payroll.entryForm.salaryReportTemp', compact('menus', 'salarytemps', 'selectedYear', 'selectedMonth', 'selectedDepartment', 'selectedPaymentMode', 'departments', 'paymentmodes'));
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
    public function show(Request $request)
    {
        //
        $selectedYear = $request->year;
        $selectedMonth = $request->month;
        $selectedDepartment = $request->dept;
        $selectedPaymentMode = $request->paymode;
        $departments = MasDepartment::get();
        $paymentmodes = EmpPaymentMode::get();

        $menus = Menu::get();
        $salarytemps = DB::select('SELECT 
                                    hrm_emp_monthly_salary_temp.emp_id AS emp_id,
                                    mas_employees.emp_name AS emp_name,
                                    hrm_emp_monthly_salary_temp.year as year,
                                    hrm_emp_monthly_salary_temp.month as month,
                                    hrm_emp_monthly_salary_temp.basic as basic,
                                    hrm_emp_monthly_salary_temp.h_rent as h_rent,
                                    hrm_emp_monthly_salary_temp.med as med,
                                    hrm_emp_monthly_salary_temp.conv as conv,
                                    hrm_emp_monthly_salary_temp.food as food,
                                    hrm_emp_monthly_salary_temp.tot_add as tot_add,
                                    hrm_emp_monthly_salary_temp.tot_deduct as tot_deduct,
                                    hrm_emp_monthly_salary_temp.salary_advanced as salary_advanced,
                                    hrm_emp_monthly_salary_temp.leave_deduct as leave_deduct,
                                    hrm_emp_monthly_salary_temp.late_days as late_days,
                                    hrm_emp_monthly_salary_temp.leave_days as leave_days,
                                    hrm_emp_monthly_salary_temp.abcent_days as abcent_days,
                                    hrm_emp_monthly_salary_temp.overtime_inhour as overtime_inhour,
                                    hrm_emp_monthly_salary_temp.generate_date as generate_date,
                                    hrm_emp_monthly_salary_temp.generate_by as generate_by,
                                    hrm_emp_monthly_salary_temp.update_date as update_date,
                                    hrm_emp_monthly_salary_temp.update_by as update_by,
                                    hrm_emp_monthly_salary_temp.approve_by as approve_by,
                                    hrm_emp_monthly_salary_temp.process_date as process_date,
                                    hrm_emp_monthly_salary_temp.process_by as process_by,
                                    hrm_emp_monthly_salary_temp.process_stat as process_stat,
                                    hrm_emp_monthly_salary_temp.pf_office as pf_office,
                                    hrm_emp_monthly_salary_temp.pf_employee as pf_employee,
                                    hrm_emp_monthly_salary_temp.revenue_stamp as revenue_stamp,
                                    hrm_emp_monthly_salary_temp.welfare_fund as welfare_fund,
                                    hrm_emp_monthly_salary_temp.payment_mode as payment_mode,

                                    (
                                        SELECT GROUP_CONCAT(CONCAT(hrm_add_comp.add_comp_name, ": ", hrm_emp_monthly_add.amnt) SEPARATOR ", ")
                                        FROM `hrm_emp_monthly_add`
                                        LEFT JOIN hrm_add_comp ON hrm_add_comp.id = hrm_emp_monthly_add.`add_comp_id`
                                        WHERE hrm_emp_monthly_add.emp_id = hrm_emp_monthly_salary_temp.emp_id
                                    ) AS additional_compensation,

                                    (
                                        SELECT GROUP_CONCAT(CONCAT(hrm_deduct_comp.deduct_comp_name, ": ", hrm_emp_monthly_deduct.amnt) SEPARATOR ", ")
                                        FROM `hrm_emp_monthly_deduct`
                                        LEFT JOIN hrm_deduct_comp ON hrm_deduct_comp.id = hrm_emp_monthly_deduct.`deduct_comp_id`
                                        WHERE hrm_emp_monthly_deduct.emp_id = hrm_emp_monthly_salary_temp.emp_id
                                    ) AS deductions

                                    FROM
                                        hrm_emp_monthly_salary_temp
                                        LEFT JOIN mas_employees ON mas_employees.id = hrm_emp_monthly_salary_temp.emp_id;
                                ');
                                // dd($salarytemps);

        return view('pages.hrm.payroll.entryForm.salaryReportTemp', compact('menus', 'salarytemps', 'selectedYear', 'selectedMonth', 'selectedDepartment', 'selectedPaymentMode', 'departments', 'paymentmodes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HrmEmpMonthlySalary $hrmEmpMonthlySalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HrmEmpMonthlySalary $hrmEmpMonthlySalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrmEmpMonthlySalary $hrmEmpMonthlySalary)
    {
        //
    }
}
