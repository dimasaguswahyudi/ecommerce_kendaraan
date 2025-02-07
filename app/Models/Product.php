<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'discount_id', 'name', 'slug', 'description', 'short_description', 'price', 'stock', 'image', 'is_active'];
}
