<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmTblEmploan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'hrm_tbl_emploan';

    protected $fillable = [
        'emp_id',
        'sanction_date',
        'start_date',
        'amnt',
        'interest',
        'no_of_installment',
        'emi',
        'status'
    ];
}
