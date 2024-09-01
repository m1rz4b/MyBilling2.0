<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblEmailSetup extends Model
{
    use HasFactory;
    protected $table = 'tbl_email_setup';

    protected $fillable = [
        'name', 
        'port', 
        'Username', 
        'Password', 
        'setFrom', 
        'SMTPAuth',
        'Host', 
        'SMTPSecure', 
        'addReplyTo', 
        'addCC', 
        'addBCC', 
        'isHTML', 
        'Mailer', 
        'send_email', 
        'receive_email', 
        'department_id', 
        'status'
    ];

    public function MasDepartment() 
    {
        return $this->belongsTo(MasDepartment::class);
    }

    public function TblEmailLog()
    {
        return $this->hasMany(TblEmailLog::class);
    }
}
