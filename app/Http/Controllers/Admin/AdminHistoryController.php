<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class AdminHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = History::where('status', 'done')->get();

        // Gabungkan data berdasarkan token yang sama
        $mergedHistories = $histories->groupBy('token')->map(function ($group) {
            return [
                'token' => $group->first()->token,
                'date' => $group->first()->date,
                'product_id' => $group->first()->product_id,
                'note' => $group->first()->note,
                'total' => $group->sum('total'), // Jumlahkan total
                'quantity' => $group->sum('quantity'), // Jumlahkan quantity
                'status' => $group->first()->status,
                'table' => $group->first()->table,
                'user_id' => $group->first()->user->name,
            ];
        });

        // Kirimkan data yang sudah digabung ke view
        return view('admin.history.index', ['histories' => $mergedHistories]);
    }
}
