<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['order_id', 'product_id', 'name_product', 'qty', 'price'];

    /**
     * Get the Order that owns the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
