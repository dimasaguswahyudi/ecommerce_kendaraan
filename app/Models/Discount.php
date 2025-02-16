<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'category_id', 'disc_percent', 'image', 'is_active', 'created_by', 'updated_by', 'deleted_by'];

    protected $casts = [
        'disc_percent' => 'integer',
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
     * Get the Category that owns the Discount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the Product for the Discount
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
