<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['category_id', 'discount_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active', 'created_by', 'updated_by', 'deleted_by'];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->created_by = $user->id;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->updated_by = $user->id;
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user) {
                $model->deleted_by = $user->id;
            }
        });
    }

    /**
     * Get the Category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the Discount that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * Get the user that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function CreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the UpdatedBy that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function UpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
