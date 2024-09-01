<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_id',
        'serv_id',
        'masinvoiceobject_id',
        'billing_year',
        'billing_month',
        'collamnt',
        'collection_date',
        'client_Id',
        'entry_by',
        'entry_date',
        'vatadjust',
        'discoun_amnt',
        'aitadjust',
        'downtimeadjust',
        'adv_rec',
    ];
}
