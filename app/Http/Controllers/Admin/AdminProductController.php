<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|string',
            'name' => 'required|max:100',
            'price' => 'required|numeric',
            'description' => 'required|max:100',
            'photo' => 'required|string',
            
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'photo' => $request->photo,
        ]);

        return redirect()->back()->with('success', 'Berhasil');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|string',
            'name' => 'required|max:100',
            'price' => 'required|numeric',
            'description' => 'required|max:100',
            'photo' => 'required|string',
        ]);

        $product = Product::find($id);
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'photo' => $request->photo,
        ]);

        return redirect()->back()->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Berhasil hapus ' . $product->name); 
    }
}
