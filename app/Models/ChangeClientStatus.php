<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeClientStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'block_reason',
        'exp_date',
        'previous_status',
        'current_status',
        'created_by'
    ];
}
