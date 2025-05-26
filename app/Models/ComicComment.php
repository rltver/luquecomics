<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComicComment extends Model
{
    /** @use HasFactory<\Database\Factories\ComicCommentFactory> */
    use HasFactory;


    protected $guarded = [];
    public function comic():BelongsTo{
        return $this->belongsTo(Comic::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
