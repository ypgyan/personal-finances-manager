<?php

namespace App\Models\Mongo;

use App\Casts\MoneyCast;
use App\Models\Mysql\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $casts = [
        'amount' => MoneyCast::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
