<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()  {
        return view('backoffice.banner.index');
    }
    public function show()
    {
        return response()->json(Banner::all());
    }
    public function store(Request $request)
    {
        Banner::create([
            'name' => $request->file('file')->store('banner', 'public'),
        ]);
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return to_route('admin.banner.index')->with('success', 'Data successfully deleted!');
    }

    public function destroyAll()
    {
        foreach (Banner::all() as $banner) {
            $banner->delete();
        }
        return to_route('admin.banner.index')->with('success', 'Banners delete successfully');
    }
}
