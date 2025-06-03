<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    /** @use HasFactory<\Database\Factories\PublisherFactory> */
    use HasFactory;
    use softDeletes;

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

    protected static function booted()
    {
        static::deleting(function ($publisher) {
            // Soft deletear sus comics
            $publisher->comics()->delete();

            // Borrar físicamente sus personajes
            $publisher->characters()->each(function ($character) {
                $character->delete();
            });
        });
    }
}
