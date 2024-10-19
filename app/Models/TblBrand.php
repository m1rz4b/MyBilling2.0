<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblBrand extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'brand_display',
        'brand_detail',
        'brand_remarks',
        'brand_user',
        'brand_pass',
        'identefire_code_brand',
        'status'
    ];
}
