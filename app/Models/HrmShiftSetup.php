<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HrmShiftSetup extends Model
{
    use HasFactory;
    protected $table = 'hrm_shift_setup';
    protected $fillable = [
        'team_id',
        'shift_id',
        'shift_team_id',
        'sun',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'status'
    ];
    
    public function TblScheduleTeam(): HasMany
    {
        return $this->hasMany(TblScheduleTeam::class, 'id');
    }
    
    public function HrmTblShift(): HasMany
    {
        return $this->hasMany(HrmTblShift::class, 'id');
    }

    public function TblShiftTeam(): HasMany
    {
        return $this->hasMany(TblShiftTeam::class, 'id');
    }
}
