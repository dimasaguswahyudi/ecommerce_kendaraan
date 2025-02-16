<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $categories;
    protected $products;
    protected $discounts;
    protected $orders;
    public function __construct(Category $categories, Product $products, Discount $discounts, Order $orders)
    {
        $this->categories = $categories->where('is_active', '1');
        $this->products = $products->where('is_active', '1');
        $this->discounts = $discounts;
        $this->orders = $orders;
    }
    public function index(Request $request) {
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($selectedMonth)->startOfMonth();
        $endDate = Carbon::parse($selectedMonth)->endOfMonth();

        $totalCategory = $this->categories->count();
        $totalProduct = $this->products->count();
        $totalDiscount = $this->discounts->count();

        $totalTransactions = Order::whereBetween('created_at', [$startDate, $endDate])->get();


        $bestSellingProducts = Product::select('products.id', 'products.name', 'products.price', 'products.image')
        ->join('order_details', 'products.id', '=', 'order_details.product_id')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->selectRaw('SUM(order_details.qty) as total_sold')
        ->groupBy('products.id', 'products.name', 'products.price', 'products.image')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

        $leastSellingProducts = Product::leftJoin('order_details', function ($join) use ($startDate, $endDate) {
            $join->on('products.id', '=', 'order_details.product_id')
                 ->join('orders', 'order_details.order_id', '=', 'orders.id')
                 ->whereBetween('orders.created_at', [$startDate, $endDate]);
        })
        ->select('products.id', 'products.name', 'products.price', 'products.image')
        ->selectRaw('COALESCE(SUM(order_details.qty), 0) as total_sold')
        ->groupBy('products.id', 'products.name', 'products.price', 'products.image')
        ->orderBy('total_sold')
        ->limit(5)
        ->get();
 
        return view('dashboard', compact('totalCategory', 'totalProduct', 'totalDiscount', 'bestSellingProducts', 'leastSellingProducts' ,'totalTransactions'));
    }
}
