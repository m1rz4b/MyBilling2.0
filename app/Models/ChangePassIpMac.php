<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangePassIpMac extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'previous_pass',
        'current_pass',
        'previous_ip',
        'current_ip',
        'previous_mac',
        'current_mac',
        'created_by'
    ];
}
