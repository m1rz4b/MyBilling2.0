<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radgroupreply extends Model
{
    use HasFactory;

    protected $table = 'radgroupreply';

    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value'
    ];
}
