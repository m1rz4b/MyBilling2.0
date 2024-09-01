<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_schedule';
    protected $fillable = [
        'sch_name', 
        'start_time', 
        'end_time', 
        'late_time', 
        'begining_start', 
        'begining_end', 
        'out_start', 
        'out_end', 
        'status'
    ];
}
