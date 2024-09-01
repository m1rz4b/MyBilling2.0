<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasInvoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'tbl_invoice_cat_id',
        'tbl_srv_type_id'
    ];

    public function Customer() 
    {
        return $this->belongsTo(Customer::class);
    }

    public function TblInvoiceCat() 
    {
        return $this->belongsTo(TblInvoiceCat::class);
    }

    public function TblSrvType() 
    {
        return $this->belongsTo(TblSrvType::class);
    }
}
