<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblSmsTemplate extends Model
{
    use HasFactory;

    protected $table = 'tbl_sms_templates';
    protected $fillable = [
        'command',
        'description',
        'status',
        'created_by'
    ];
}
