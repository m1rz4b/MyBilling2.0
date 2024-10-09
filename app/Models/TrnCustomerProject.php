<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnCustomerProject extends Model
{
    use HasFactory;
    protected $table = 'trn_customer_project';
	protected $fillable = ['project_name', 'client_id','contract_person', 'address', 'mobile1','active_statust'];
}
