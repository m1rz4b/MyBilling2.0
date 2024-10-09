<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasBank extends Model
{
    use HasFactory;
	 protected $fillable = ['bank_name', 'status'] ;
}
