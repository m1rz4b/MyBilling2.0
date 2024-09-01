<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use HasFactory;

    public function Customer() 
    {
        return $this->hasMany(Customer::class);
    }

    public function TblZone() 
    {
        return $this->belongsTo(TblZone::class);
    }

    public function Box() 
    {
        return $this->hasMany(Box::class);
    }

}
