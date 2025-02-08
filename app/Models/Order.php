<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['customer_id', 'no_transaction', 'grand_total'];

    /**
     * Get all of the OrderDetail for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OrderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get the Customer that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
