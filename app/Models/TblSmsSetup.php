<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblSmsSetup extends Model
{
    use HasFactory;

    protected $table = 'tbl_sms_setup';
    protected $fillable = [
        'name',
        'sms_url',
        'submit_param',
        'type',
        'status',
        'created_by'
    ];
}
