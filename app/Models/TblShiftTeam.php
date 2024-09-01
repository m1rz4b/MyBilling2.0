<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblShiftTeam extends Model
{
    use HasFactory;
    protected $table = 'tbl_shift_team';
    protected $fillable = [
        'team_id',
        'level',
        'emp_id',
        'status'
    ];

    public function HrmShiftSetup()
    {
        return $this->belongsTo(HrmShiftSetup::class, 'shift_team_id');
    }
}
