<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeHotspotToPppoe extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'previous_ip',
        'current_ip',
        'static_ip',
        'created_by'
    ];
}
