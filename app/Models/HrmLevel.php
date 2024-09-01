<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmLevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'hrm_level';
    protected $fillable = ['level_name', 'status'];
}
