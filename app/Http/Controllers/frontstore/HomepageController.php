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
        $this->categories = $categories;
        $this->discounts = $discounts;
    }
    public function index()  {
        $categories = $this->categories->where('is_active', '1')->with('Product')->get();
        $banners = $this->banners->all();
        return view('frontstore.index', compact('categories', 'banners'));
    }
}
