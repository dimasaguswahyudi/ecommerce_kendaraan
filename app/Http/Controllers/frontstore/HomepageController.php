<?php

namespace App\Http\Controllers\frontstore;

use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class HomepageController extends Controller
{
    protected $categories;
    protected $discounts;
    protected $banners;
    protected $products;
    protected $orders;
    protected $orderDetails;
    protected $customers;
    public function __construct(Banner $banners, Category $categories, Discount $discounts, Product $products, Order $orders, OrderDetail $orderDetails, Customer $customers)
    {
        $this->banners = $banners;
        $this->categories = $categories->where('categories.is_active', '1');
        $this->discounts = $discounts->where('discounts.is_active', '1');
        $this->products = $products->where('products.is_active', '1');
        $this->orders = $orders;
        $this->orderDetails = $orderDetails;
        $this->customers = $customers;
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
    public function chart()  {
        $banners = $this->banners->all();
        $discounts = $this->discounts->has('Category')->get()->groupBy('Category.name');  

        $products = $this->products->has('Category')->with('Discount')->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name')
            ->select('products.*')->get()->groupBy('Category.name');

        return view('frontstore.chart', compact('banners', 'discounts', 'products'));
    }
    public function cartShow(Request $request) :JsonResponse
    {
        $products = Product::whereIn('id', $request->product_ids)->with('Discount')->get();
        return response()->json([
            'products' => $products
        ]);
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

    public function order(Request $request)  {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $formattedDate = now()->format('d-m-Y');
            $orderCount = Order::whereDate('created_at', now()->toDateString())->count() + 1;

            // Buat nomor transaksi unik: TRX-{tgl}-{bln}-{thn}-{no urut}
            $no_transaction = "TRX-" . str_replace("-", "", $formattedDate) . "-" . str_pad($orderCount, 4, '0', STR_PAD_LEFT);

            $customer = $this->customers->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $order = $this->orders->create([
                'customer_id' => $customer->id,
                'no_transaction' => $no_transaction,
                'grand_total' => $request->grand_total
            ]);
            
            foreach ($request->order_detail as $key => $value) {
                $this->orderDetails->create([
                    'order_id' => $order->id,
                    'name_product' => $value['product'],
                    'product_id' => $value['product_id'],
                   'price' => $value['qty'] * ($value['price'] - ($value['price'] * ($value['discount'] ?? 0) / 100)),
                    'qty' => $value['qty']
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Order Berhasil Dibuat']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
    
}
