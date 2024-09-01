<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmTblShift extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hrm_tbl_shift';
    protected $fillable = [
        'shift_name', 
        'start_time', 
        'end_time', 
        'begining_start', 
        'begining_end', 
        'out_start', 
        'out_end', 
        'status'
    ];

    public function HrmShiftSetup()
    {
        return $this->belongsTo(HrmShiftSetup::class, 'shift_id');
    }
}
