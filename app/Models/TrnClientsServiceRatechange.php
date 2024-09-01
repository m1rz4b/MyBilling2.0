<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnClientsServiceRatechange extends Model
{
    use HasFactory;

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function TrnClientsService()
    {
        return $this->belongsTo(TrnClientsService::class);
    }
}
