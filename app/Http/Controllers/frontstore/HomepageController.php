<?php

namespace App\Http\Controllers\frontstore;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index()  {
        $categories = Category::where('is_active', '1')->with('Product')->get();
        return view('frontstore.index', compact('categories'));
    }
}
