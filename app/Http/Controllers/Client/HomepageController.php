<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

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
        $category = Category::find($id);
        return view('client.category', compact('products', 'categories', 'category'));
    }

    public function detailProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('client.detail-product', compact('product', 'categories'));
    }

    public function cart()
    {
        $carts = History::where('status', 'cart')->where('user_id', Auth::user()->id)->get();
        $categories = Category::all();
        return view('client.cart', compact('carts', 'categories'));
    }

    public function cartStore(Request $request, $id)
    {
        $product = Product::find($id);
        $note = $request->note;
        $quantity = $request->quantity;
        $history = History::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'note' => $note,
            'quantity' => $quantity,
            'total' => $product->price * $quantity,
            'status' => 'cart',
            'date' => now(),
        ]);
        return redirect()->route('cart');
    }

    public function checkout(Request $request)
    {
        // Ambil keranjang pengguna saat ini
        $userId = Auth::user()->id; // Pastikan pengguna login
        dd($userId);
        $carts = History::where('user_id', $userId)->get();

        // Periksa apakah keranjang kosong
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        // Buat pesanan baru
        $order = History::create([
            'user_id' => $userId,
            'status' => 'process', // Status diubah menjadi "process"
            'total_price' => $totalPrice,
        ]);

        // Pindahkan item dari keranjang ke pesanan
        foreach ($carts as $cart) {
            $order->orderItems()->create([
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'note' => $cart->note,
                'price' => $cart->product->price,
            ]);

            // Hapus item dari keranjang
            $cart->delete();
        }

        // Redirect dengan pesan sukses
        return redirect()->route('orders.index')->with('success', 'Pesanan Anda telah berhasil diproses!');
    }
}
