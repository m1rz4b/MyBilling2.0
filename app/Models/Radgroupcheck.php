<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radgroupcheck extends Model
{
    use HasFactory;

    protected $table = 'radgroupcheck';

    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value'
    ];
}
