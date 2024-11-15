<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = [
        'name',
        'opening_hours',
        'calculation_enabled',
        'unique_id',
    ];
    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
