<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_Id',
        'collection_date',
        'money_receipt',
        'pay_type',
        'bank_id',
        'cheque_no',
        'cheque_date',
        'coll_amount',
        'remarks',
        'coll_by',
        'entry_by',
        'entry_date',
        'app_stat',
        'app_by',
        'app_date',
        'adv_stat',
        'cur_arrear',
        'vatadjust',
        'discoun_amnt',
        'aitadjust',
        'downtimeadjust',
        'adv_rec',
        'journal_id',
        'transaction_id',
        'online_plat_from',
    ];

    public function Customer() 
    {
        return $this->belongsTo(Customer::class);
    }
}

