<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasDepartment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'department',
        'status',
        'created_by'
    ];

    public function TblEmailSetup()
    {
        return $this->hasMany(TblEmailSetup::class);
    }

    public function MasEmployee()
    {
        return $this->hasMany(MasEmployee::class);
    }
}
