<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrotikGraph extends Model
{
    use HasFactory;
    protected $table = 'tbl_mikrotik_graphing';
    protected $fillable = ['router_id', 'interface', 'allow_address', 'store_on', 'status'];

    public function TblRouter() 
    {
        return $this->belongsTo(TblRouter::class);
    }
}
