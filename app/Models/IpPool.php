<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpPool extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_ip_pool';


    protected $fillable = [
        'name', 'ranges', 'router_id', 'status'
    ];

    public function TblRouter() 
    {
        return $this->belongsTo(TblRouter::class);
    }
}
