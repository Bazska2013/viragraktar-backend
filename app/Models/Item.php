<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'store_id',
//        'image',
    ];
    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
