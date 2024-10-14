<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadiusServer extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        'server_ip',
        'server_name',
        'auth_api_url',
        'acct_api_url',
        'status',
        'created_by'
    ];
}
