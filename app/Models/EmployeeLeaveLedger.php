<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveLedger extends Model
{
    use HasFactory;
    protected $table = 'employee_leave_ledger';
    protected $fillable = [
        'employee_id',
        'leave_type',
        'year',
        'total',
        'created_by'
    ];
}
