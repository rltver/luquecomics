<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $table = 'order_comic';

    protected $fillable = ['comic_id', 'quantity', 'unit_price'];

    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }
    public function comic():BelongsTo{
        return $this->belongsTo(Comic::class)->withTrashed();
    }
}
