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
        $histories = History::all()->count();
        return view('admin.dashboard', compact('users', 'categories', 'products', 'histories'));
    }
}
