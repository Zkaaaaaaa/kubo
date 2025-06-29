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
use App\Notifications\DatabaseOrderNotification;
use App\Models\User;

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
        $request->validate([
            'quantity' => 'required|numeric|min:1|max:10',
        ]);
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
        $request->validate([
            'change' => 'required|integer|between:-10,10',
        ]);

        $cart = History::find($id);
        if (!$cart || $cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Keranjang tidak ditemukan.']);
        }

        $newQuantity = $cart->quantity + $request->change;

        if ($newQuantity < 1) {
            $cart->delete(); // Hapus item jika jumlah kurang dari 1
            return response()->json(['success' => true, 'deleted' => true]);
        }

        if ($newQuantity > 10) {
            return response()->json(['success' => false, 'message' => 'Jumlah maksimal 10 porsi per item.']);
        }

        $cart->quantity = $newQuantity;
        $cart->total = $cart->product->price * $newQuantity; // Update total juga
        $cart->save();

        return response()->json([
            'success' => true,
            'quantity' => $cart->quantity,
            'total' => $cart->total
        ]);
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
        $request->validate([
            'quantity' => 'required|numeric|min:1|max:10',
        ]);
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

                // Send notification to all employees
                $employees = User::where('role', 'employee')->get();
                foreach ($employees as $employee) {
                    $employee->notify(new DatabaseOrderNotification($cart, Auth::user()));
                }
            }

            return view('client.finish', compact('categories'))->with('message', 'Payment completed successfully.');
        }

        return redirect()->route('cart')->with('error', 'Payment failed or canceled.');
    }

    public function myOrders()
    {
        $categories = Category::all();
        $orders = History::where('user_id', Auth::user()->id)
            ->where('status', '!=', 'cart')
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('token')
            ->map(function ($group) {
                return (object)[
                    'token' => $group->first()->token,
                    'items' => $group,
                    'total_quantity' => $group->sum('quantity'),
                    'total_amount' => $group->sum('total'),
                    'status' => $group->first()->status,
                    'created_at' => $group->first()->created_at
                ];
            });

        return view('client.my-orders', compact('orders', 'categories'));
    }

    public function orderDetail($id)
    {
        $categories = Category::all();
        $order = History::with('product')->findOrFail($id);

        // Get all items with the same token
        $orderItems = History::where('token', $order->token)
            ->with('product')
            ->get();

        return view('client.order-detail', compact('order', 'orderItems', 'categories'));
    }

    // remove from cart
    public function removeFromCart($id)
    {
        $cart = History::find($id);
        if ($cart && $cart->user_id == Auth::user()->id) {
            $cart->delete();
        }
        return redirect()->route('cart');
    }
}
