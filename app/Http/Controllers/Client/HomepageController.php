<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\History;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $promo = Promo::find(1);
        return view('client.index', compact('products', 'categories', 'promo'));
    }

    public function category($id)
    {
        $products = Product::where('category_id', $id)->get();
        $categories = Category::all();
        $category = Category::find($id);
        return view('client.category', compact('products', 'categories', 'category'));
    }

    // detail product
    public function detailProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('client.detail-product', compact('product', 'categories'));
    }

    // cart
    public function cart()
    {
        $carts = History::where('status', 'cart')->where('user_id', Auth::user()->id)->get();
        $categories = Category::all();
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snap_token = Snap::getSnapToken($params);

        return view('client.cart', compact('carts', 'categories', 'snap_token'));
    }

    // add to cart
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

    // midtrans
    public function finish(Request $request)
    {
        return $request->input('result_data');
    }


    // update jumlah item
    public function updateQuantity(Request $request, $id)
    {
        $cart = History::find($id);
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Keranjang tidak ditemukan.']);
        }

        $newQuantity = $cart->quantity + $request->change;

        if ($newQuantity < 1) {
            $cart->delete(); // Hapus item jika jumlah kurang dari 1
            return response()->json(['success' => true]);
        }

        $cart->quantity = $newQuantity;
        $cart->save();

        return response()->json(['success' => true]);
    }
}
