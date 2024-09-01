<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRouterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'previous_router',
        'current_router',
        'created_by'
    ];
}
