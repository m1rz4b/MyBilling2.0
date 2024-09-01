<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingStatus extends Model
{
    use HasFactory;

    public function TrnClientsService() 
    {
        return $this->hasMany(TrnClientsService::class);
    }
}
