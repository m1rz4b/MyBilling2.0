<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblZone extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tbl_zone';
    protected $fillable = ['zone_name','zone_code','discount','advance_amount', 'status'] ;

    public function Customer() 
    {
        return $this->hasMany(Customer::class);
    }

    public function SubZone() 
    {
        return $this->hasMany(SubZone::class);
    }
}
