<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblLeave extends Model
{
    use HasFactory;
    protected $table = 'tbl_leave';
    protected $fillable = [
        'employee_id',
        'day_type',
        'from_date',
        'to_date',
        'days',
        'leavetype_id',
        'remarks',
        'created_by'
    ];
}
