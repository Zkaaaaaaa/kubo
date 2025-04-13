<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\History;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->count();
        $categories = Category::all()->count();
        $products = Product::all()->count();
        
        // Get history counts grouped by status and token
        $historyCounts = History::selectRaw('status, count(DISTINCT token) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get total orders (unique tokens)
        $totalOrders = History::select('token')->distinct()->count();

        // Ensure all statuses are present with 0 count if they don't exist
        $histories = [
            'cart' => $historyCounts['cart'] ?? 0,
            'process' => $historyCounts['process'] ?? 0,
            'done' => $historyCounts['done'] ?? 0,
            'total' => $totalOrders
        ];

        return view('admin.dashboard', compact('users', 'categories', 'products', 'histories'));
    }
}
