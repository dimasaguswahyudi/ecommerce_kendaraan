<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Requests\DiscountRequest;
use Illuminate\Support\Facades\Storage;

class DiscountController extends Controller
{
    protected $categories;
    protected $discounts;
    public function __construct(Category $categories, Discount $discounts)
    {
        $this->categories = $categories;
        $this->discounts = $discounts;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = $this->discounts->with('Category')->orderByDesc('updated_at')->paginate(10);
        $categories = $this->categories->where('is_active', '1')->orderBy('name')->get(['id', 'name']);
        return view('backoffice.discount.index', compact('discounts', 'categories'));
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
    public function store(DiscountRequest $request)
    {
        $validated = $request->all();
        $validated['is_active'] = $request->is_active == 'true' ? '1' : '0';
        if (isset($validated['image'])) {
            $validated['image'] = $request->file('image')->store('discount', 'public');
        }
        $this->discounts->create($validated);
        return to_route('admin.discount.index')->with('success', 'Data successfully created!');
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
    public function update(DiscountRequest $request, Discount $discount)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('discount', 'public');
            if ($discount->image) {
                Storage::disk('public')->delete($discount->image);
            }
        }

        $dataUpdated = [
            'name' => $request->name,
            'disc_percent' => $request->disc_percent,
            'is_active' => $request->is_active == 'true' ? '1' : '0',
            'category_id' => $request->category_id
        ];

        if ($image) $dataUpdated['image'] = $image;
        $discount->update($dataUpdated);
        return to_route('admin.discount.index')->with('success', 'Data successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return to_route('admin.discount.index')->with('success', 'Data successfully deleted!');
    }
}
