<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    /** @use HasFactory<\Database\Factories\PublisherFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'creation_date' => 'date',
    ];

    public function characters(){
        return $this->hasMany(Character::class);
    }

    public function comics():HasMany{
        return $this->hasMany(Comic::class);
    }
}
