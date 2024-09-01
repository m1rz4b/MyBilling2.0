<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radusergroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id'
    ];
    protected $table = 'radusergroup';
}
