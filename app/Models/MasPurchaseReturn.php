<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasPurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'bill_number',
        'client_type',
        'invoice_date',
        'customer_id',
        'remarks',
        'vat',
        'vatper',
        'bill_amount',
        'total_bill',
        'collection_amnt',
        'ait_adjustment',
        'ait_adj_date',
        'vat_adjust_ment',
        'vat_adjust_date',
        'other_adjustment',
        'discount_amnt',
        'discount_date',
        'comments',
        'receive_status',
        'view_status',
        'invoice_cat',
        'other_add_item',
        'other_add_amount',
        'adv_rec',
        'next_inv_date',
        'project_id',
        'journal_status',
        'journal_id',
        'mas_sup_inv_id'
    ];
}
