<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblScheduleTeam extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tbl_schedule_team';
    protected $fillable = ['team_name', 'status'];

    public function HrmShiftSetup()
    {
        return $this->belongsTo(HrmShiftSetup::class, 'team_id');
    }
}
