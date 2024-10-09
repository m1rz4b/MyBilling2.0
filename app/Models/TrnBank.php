<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnBank extends Model
{
    use HasFactory;
	protected $fillable = ['bank_id', 'account_no', 'branch', 'contract_person', 'address1', 'phone', 'status'] ;
}
