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
    // SEARCH
    public function search(Request $request)
    {
        $categories = Category::all();
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")
            ->get();

        return view('client.search', compact('products', 'query', 'categories'));
    }

    // homepage
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $promo = Promo::find(1);
        return view('client.index', compact('products', 'categories', 'promo'));
    }

    // category
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

    // add to cart
    public function cartStore(Request $request, $id)
    {
        $product = Product::find($id);
        $note = $request->note;
        $quantity = $request->quantity;
        $token = Auth::user()->id . '-' . now()->format('Y-m-d');
        // dd($token);
        $history = History::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product->id,
            'note' => $note,
            'quantity' => $quantity,
            'total' => $product->price * $quantity,
            'status' => 'cart',
            'date' => now()->format('Y-m-d'),
            'token' => $token,
        ]);
        return redirect()->route('cart');
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

    // cart
    public function cart()
    {
        $carts = History::where('status', 'cart')->where('user_id', Auth::user()->id)->get();
        $categories = Category::all();
        if ($carts->isEmpty()) {
            $snap_token = null;
            return view('client.cart', compact('carts', 'categories', 'snap_token'));
        }
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $totalAmount = $carts->sum(function ($cart) {
            return $cart->product ? $cart->product->price * $cart->quantity : 0;
        });

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => (int)$totalAmount,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snap_token = Snap::getSnapToken($params);

        return view('client.cart', compact('carts', 'categories', 'snap_token'));
    }

    // midtrans
    public function finish(Request $request)
    {
        $categories = Category::all();
        $request->validate([
            'result_data' => 'required',
        ]);

        $result = json_decode($request->input('result_data'), true);

        if (isset($result['status_code']) && $result['status_code'] == 200) {
            // Perbarui status keranjang menjadi 'process'
            $carts = History::where('status', 'cart')
                ->where('user_id', Auth::user()->id)
                ->get();

            foreach ($carts as $cart) {
                $cart->status = 'process';
                $cart->save();
            }

            return view('client.finish', compact('categories'))->with('message', 'Payment completed successfully.');
        }

        return redirect()->route('cart')->with('error', 'Payment failed or canceled.');
    }
}
