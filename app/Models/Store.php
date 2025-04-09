<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'opening_hours',
        'calculation_enabled',
        'unique_id',
        'labels',
    ];

    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
