<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblSrvType extends Model
{
    use HasFactory;

    public function MasInvoice()
    {
        return $this->belongsTo(MasInvoice::class);
    }
}
