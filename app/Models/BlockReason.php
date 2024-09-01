<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockReason extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'block_reason_name',
        'block_reason_desc',
        'status',
        'created_by'
    ];

    public function TrnClientsService()
    {
        return $this->belongsTo(TrnClientsService::class);
    }
}
