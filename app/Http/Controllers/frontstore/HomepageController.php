<?php

namespace App\Http\Controllers\frontstore;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class HomepageController extends Controller
{
    protected $categories;
    protected $discounts;
    protected $banners;
    protected $products;
    public function __construct(Banner $banners, Category $categories, Discount $discounts, Product $products)
    {
        $this->banners = $banners;
        $this->categories = $categories->where('categories.is_active', '1');
        $this->discounts = $discounts->where('discounts.is_active', '1');
        $this->products = $products->where('products.is_active', '1');
    }
    public function index(Request $request) {
        $categories = $this->categories->with('Product')->orderBy('name')->get();
        $banners = $this->banners->all();

        $discounts = $this->discounts->has('Category')->get()->groupBy('Category.name');  

        $products = $this->products->has('Category')->with('Discount')->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name')
            ->select('products.*')->get()->groupBy('Category.name');
    
        return view('frontstore.index', compact('categories', 'banners', 'discounts', 'products'));
    }

    public function filter(Request $request) :JsonResponse {
        $products = $this->products->has('Category')->with('Discount')->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name')
            ->select('products.*');
        $discounts = $this->discounts->has('Category');  
        if (filled($request->category_id)) {
            $products = $products->where('products.category_id', $request->category_id);
            $discounts = $discounts->where('discounts.category_id', $request->category_id);
        }
        if (filled($request->discount_id)) {
            $products = $products->whereHas('Discount', function ($query) use ($request) {
                $query->where('discounts.id', $request->discount_id);
            });
        }
        $products = $products->get()->groupBy('Category.name');
        $discounts = $discounts->get()->groupBy('Category.name');

        return response()->json([
            'products' => $products,
            'discount' => $discounts
        ]);
    }
    
}
