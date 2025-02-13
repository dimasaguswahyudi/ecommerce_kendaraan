<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $categories;
    protected $products;
    protected $discounts;
    public function __construct(Category $categories, Product $products, Discount $discounts)
    {
        $this->categories = $categories->where('is_active', '1');
        $this->products = $products->where('is_active', '1');
        $this->discounts = $discounts;
    }
    public function index() {
        $totalCategory = $this->categories->count();
        $totalProduct = $this->products->count();
        $totalDiscount = $this->discounts->count();
        return view('dashboard', compact('totalCategory', 'totalProduct', 'totalDiscount'));
    }
}
