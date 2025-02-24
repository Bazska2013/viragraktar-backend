<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'items',
        'total',
        'credit',
        'store_id',
        'user_id',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
