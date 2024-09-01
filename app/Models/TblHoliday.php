<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblHoliday extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'holiday_name',
        'holiday_date',
        'allowance_status',
        'status',
        'created_by'
    ];
}
