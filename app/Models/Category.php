<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    /**
     * Get all of the Discount for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Discount(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
}
