<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'required|max:10000',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $file_name = $product->name . '-' . time() . '.' . $photo->getClientOriginalExtension();
                
                // simpan nama file ke database
                $product->photo = $file_name;
                $product->save();

                // simpan file gambar ke sistem
                $photo->move(public_path('storage'), $file_name);
            }

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'required|max:10000',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);
            $oldPhoto = $product->photo;

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($oldPhoto && file_exists(public_path('storage/' . $oldPhoto))) {
                    File::delete(public_path('storage/' . $oldPhoto));
                }

                $photo = $request->file('photo');
                $file_name = $product->name . '-' . time() . '.' . $photo->getClientOriginalExtension();
                
                // simpan nama file ke database
                $product->photo = $file_name;
                $product->save();

                // simpan file gambar ke sistem
                $photo->move(public_path('storage'), $file_name);
            }

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Delete photo if exists
            if ($product->photo && file_exists(public_path('storage/' . $product->photo))) {
                File::delete(public_path('storage/' . $product->photo));
            }
            
            $product->delete();
            return redirect()->back()->with('success', 'Berhasil hapus ' . $product->name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
