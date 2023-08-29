<?php

namespace App\Models\Mongo;

use App\Models\Mysql\Account;
use App\Models\Mysql\Card;
use App\Models\Mysql\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
