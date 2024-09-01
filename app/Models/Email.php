<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'name',
        'email',
        'subject',
        'body_text',
        'body_html',
        'receiver_email'
    ];
}
