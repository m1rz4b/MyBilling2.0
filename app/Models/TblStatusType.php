<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblStatusType extends Model
{
    use HasFactory;

    public function TrnClientsService()
    {
        return $this->belongsTo(TrnClientsService::class);
    }
}
