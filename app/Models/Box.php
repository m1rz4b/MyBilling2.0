<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    public function SubZone()
    {
        return $this->belongsTo(SubZone::class);
    }

    public function TrnClientsService() 
    {
        return $this->hasMany(TrnClientsService::class);
    }
}