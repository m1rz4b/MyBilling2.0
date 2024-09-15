<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'suboffice_id',
        'emp_name',
        'emp_pin',
        'date_of_joining',
        'mobile',
        'email',
        'department_id',
        'designation_id',
        'emp_status_id',
        'reporting_manager',
        'reporting_manager_des',
        'salary_status',
        'address',
        'payment_mode',
        'bank_id',
        'acc_no',
        'shift_id',
        'user_group_id',
        'e-tin',
        'last_increment_date',
        'last_promotion_date'
    ];
    protected $table = 'mas_employees';

    public function MasDepartment()
    {
        return $this->belongsTo(MasDepartment::class);
    }

    public function Designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
