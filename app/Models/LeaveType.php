<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_leavetype';

    protected $fillable = ['name', 'short_name', 'default_allocation', 'carry_forward', 'carry_max_days', 'status'];
}
