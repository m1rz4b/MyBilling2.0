<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_type_name',
        'status'
    ];
    public function TrnClientsService() 
    {
        return $this->hasMany(TrnClientsService::class);
    }
}
