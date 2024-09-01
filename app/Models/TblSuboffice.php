<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblSuboffice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'contact_person',
        'contact_number',
        'email',
        'address',
        'status',
        'created_by'
    ];

    public function Customer() 
    {
        return $this->hasMany(Customer::class);
    }
}
