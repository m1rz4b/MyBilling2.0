<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmEmpJobHistory extends Model
{
    use HasFactory;
    protected $table = 'hrm_emp_job_history';
    protected $fillable = [
        'emp_id',
        'designation',
        'pro_date'
    ];
}
