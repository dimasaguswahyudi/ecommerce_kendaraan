<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('updated_at')->paginate(10);
        return view('backoffice.category.index', compact('categories'));
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
    public function store(CategoryRequest $request)
    {
        $validated = $request->all();
        $validated['is_active'] = $request->is_active == 'true' ? '1' : '0';
        if (isset($validated['image'])) {
            $validated['image'] = $request->file('image')->store('category', 'public');
        }
        Category::create($validated);
        return to_route('admin.category.index')->with('success', 'Data successfully created!');
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
    public function update(CategoryRequest $request, Category $category)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('categories', 'public');
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
        }

        $dataUpdated = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->is_active == 'true' ? '1' : '0'
        ];

        if ($image) $dataUpdated['image'] = $image;
        $category->update($dataUpdated);
        return to_route('admin.category.index')->with('success', 'Data successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('admin.category.index')->with('success', 'Data successfully deleted!');
    }
}
