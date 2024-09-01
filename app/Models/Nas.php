<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nasname',
        'shortname',
        'type',
        'ports',
        'secret',
        'server',
        'community',
        'description',
        'tbl_router_id'
    ];

    public function radacct()
    {
        return $this->hasMany(Radacct::class, 'nasipaddress', 'nasname');
    }

    public function TblRouter()
    {
        return $this->belongsTo(TblRouter::class);
    }
}
