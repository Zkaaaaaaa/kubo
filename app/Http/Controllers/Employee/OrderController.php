<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Events\NewOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = History::where('status', 'process')
            ->with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('token')
            ->map(function ($group) {
                return (object)[
                    'token' => $group->first()->token,
                    'user' => $group->first()->user,
                    'items' => $group,
                    'total_quantity' => $group->sum('quantity'),
                    'total_amount' => $group->sum('total'),
                    'created_at' => $group->first()->created_at
                ];
            });
            
        return view('employee.orders.index', compact('orders'));
    }

    public function markAsDone($id)
    {
        $order = History::findOrFail($id);
        
        // Update all orders with the same token
        History::where('token', $order->token)
            ->update(['status' => 'done']);

        return redirect()->route('employee.orders.index')
            ->with('success', 'Order marked as done successfully.');
    }

    public function store(Request $request)
    {
        // Your existing order creation logic here
        $order = History::create($request->all());

        // Notify all employees
        $employees = User::where('role', 'employee')->get();
        foreach ($employees as $employee) {
            $employee->notify(new NewOrderNotification($order));
        }

        // Broadcast the new order event
        event(new NewOrder($order));

        return redirect()->back()->with('success', 'Order created successfully');
    }
} 