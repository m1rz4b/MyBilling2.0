<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmAddComp extends Model
{
    use HasFactory;
    protected $table = 'hrm_add_comp';

    protected $fillable = [
        'add_comp_name',
        'type',
        'percent',
        'amnt',
        'gl_code'
    ];
}
