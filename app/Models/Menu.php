<?php

namespace App\Models;
use App\Models\Scopes\MenuScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name','route','pid','level', 'serial', 'status', 'is_parent'] ;
    protected static function booted(): void
    {
        static::addGlobalScope(new MenuScope);
    }

    public function children()
    {
        return $this->hasMany(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

}
