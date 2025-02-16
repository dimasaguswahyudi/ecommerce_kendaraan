<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'image', 'is_active', 'created_by', 'updated_by', 'deleted_by'];

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
     * Get all of the Discount for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Discount(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    /**
     * Get all of the Product for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Product(): HasMany
    {
        return $this->hasMany(Product::class);
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
