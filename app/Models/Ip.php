<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ip extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'package',
        'ip',
        'status',
        'created_by'
    ];
}
