<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\History;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('client.index', compact('products', 'categories'));
    }

    public function category($id)
    {
        $products = Product::where('category_id', $id)->get();
        $categories = Category::all();
        return view('client.category', compact('products', 'categories'));
    }

    public function detailProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('client.detail-product', compact('product', 'categories'));
    }

    public function cart()
    {
        $carts = History::where('status', 'cart')->get();
        $categories = Category::all();
        return view('client.cart', compact('carts', 'categories'));
    }
}
