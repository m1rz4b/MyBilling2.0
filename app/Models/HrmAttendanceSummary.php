<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmAttendanceSummary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hrm_attendance_summary';

    protected $fillable = [
        'employee_id',
        'date',
        'start_date',
        'end_date',
        'total_time',
        'over_time',
        'late_mark',
        'early_mark',
        'leave_mark',
        'gov_holiday',
        'weekly_holiday',
        'absent',
        'created_by'
    ];
}