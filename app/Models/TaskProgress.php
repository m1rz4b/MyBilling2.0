<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskProgress extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'description',
        'duration',
        'status',
        'created_by'
    ];
}
