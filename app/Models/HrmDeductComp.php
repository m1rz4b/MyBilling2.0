<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmDeductComp extends Model
{
    use HasFactory;
    protected $table = 'hrm_deduct_comp';

    protected $fillable = [
        'deduct_comp_name',
        'type',
        'percent',
        'amnt',
        'gl_code'
    ];
}
