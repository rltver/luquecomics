<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends Model
{
    /** @use HasFactory<\Database\Factories\PostCommentFactory> */
    use HasFactory;

    public function post():BelongsTo{
        return $this->belongsTo(Post::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
