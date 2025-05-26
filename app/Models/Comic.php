<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comic extends Model
{
    /** @use HasFactory<\Database\Factories\ComicFactory> */
    use HasFactory;

    protected $guarded = [];

    public function publisher():BelongsTo{
        return $this->belongsTo(Publisher::class);
    }

    public function ComicComments():HasMany{
        return $this->hasMany(ComicComment::class);
    }

    public function characters():BelongsToMany{
        return $this->belongsToMany(Character::class);
    }

    public function orderItems():HasMany{
        return $this->hasMany(OrderItem::class);
    }
}
