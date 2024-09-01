<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['emp_pin'];
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
