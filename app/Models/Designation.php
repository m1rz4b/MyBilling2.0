<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'mas_designation';
    protected $fillable = ['designation', 'status'];

    public function MasEmployee()
    {
        return $this->hasMany(MasEmployee::class);
    }
}
