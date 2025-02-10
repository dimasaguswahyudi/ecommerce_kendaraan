<?php

namespace App\Http\Controllers\frontstore;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    protected $categories;
    protected $discounts;
    protected $banners;
    public function __construct(Banner $banners, Category $categories, Discount $discounts)
    {
        $this->banners = $banners;
        $this->categories = $categories->where('is_active', '1');
        $this->discounts = $discounts->where('is_active', '1');
    }
    public function index()  {
        $categories = $this->categories->with('Product')->get();
        $banners = $this->banners->all();
        $discounts = $this->discounts->has('Category')->get()->groupBy('Category.name');
        return view('frontstore.index', compact('categories', 'banners', 'discounts'));
    }
}
