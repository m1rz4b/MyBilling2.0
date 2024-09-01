<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblEmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['command', 'description', 'status'];
}
