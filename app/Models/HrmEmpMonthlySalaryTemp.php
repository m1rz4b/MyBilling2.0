<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmEmpMonthlySalaryTemp extends Model
{
    use HasFactory;

    protected $table = 'hrm_emp_monthly_salary_temp';

    protected $fillable = [
        'emp_id',
        'year',
        'month',
        'basic',
        'h_rent',
        'med',
        'conv',
        'food',
        'tot_add',
        'tot_deduct',
        'salary_davanced',
        'leave_deduct',
        'late_days',
        'leave_days',
        'abcent_days',
        'overtime_inhour',
        'generate_date',
        'generate_by',
        'update_date',
        'update_by',
        'approve_by',
        'process_date',
        'process_by',
        'process_stat',
        'pf_office',
        'pf_employee',
        'revenue_stamp',
        'welfare_fund',
        'payment_mode'
    ];
}
