<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblBillType extends Model
{
    use HasFactory;
    protected $fillable = ['bill_type_name'];

    public function TrnClientsService() 
    {
        return $this->hasMany(TrnClientsService::class);
    }
}
