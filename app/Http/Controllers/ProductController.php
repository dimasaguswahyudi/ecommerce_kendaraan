<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $products;   
    protected $categories;
    protected $discounts;
    public function __construct(Product $products, Category $categories, Discount $discounts)
    {
        $this->products = $products;
        $this->categories = $categories;
        $this->discounts = $discounts;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->products->with('Category', 'Discount')->orderByDesc('updated_at')->paginate(10);
        $categories = $this->categories->orderBy('name')->get(['id', 'name']);
        $discounts = $this->discounts->orderBy('name')->get(['id', 'name']);
        return view('backoffice.product.index', compact('products', 'categories', 'discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->all();
        $validated['is_active'] = $request->is_active == 'true' ? '1' : '0';
        if (isset($validated['image'])) {
            $validated['image'] = $request->file('image')->store('product', 'public');
        }
        $this->products->create($validated);
        return to_route('admin.product.index')->with('success', 'Data successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('product', 'public');
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
        }

        $dataUpdated = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'is_active' => $request->is_active == 'true' ? '1' : '0',
            'category_id' => $request->category_id,
            'discount_id' => $request->discount_id
        ];

        if ($image) $dataUpdated['image'] = $image;
        $product->update($dataUpdated);
        return to_route('admin.product.index')->with('success', 'Data successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('admin.product.index')->with('success', 'Data successfully deleted!');
    }
}
