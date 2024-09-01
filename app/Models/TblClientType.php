<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TblClientType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'hotspot',
        'unit',
        'pcq',
        'price',
        'days',
        'view_portal',
        'reseller_id',
        'share_rate',
        'status',
        'created_by'
    ];

    public function TrnClientsService()
    {
        return $this->hasMany(TrnClientsService::class);
    }
}
