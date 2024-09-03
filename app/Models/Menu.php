<?php

namespace App\Models;
use App\Models\Scopes\MenuScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected static function booted(): void
    {
        static::addGlobalScope(new MenuScope);
    }

}
