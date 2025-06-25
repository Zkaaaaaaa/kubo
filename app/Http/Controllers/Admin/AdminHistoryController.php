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
    public function index(Request $request)
    {
        $query = History::where('status', 'done');

        // Filter berdasarkan tanggal jika tersedia
        if ($request->has(['start_date', 'end_date']) && $request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $histories = $query->get();

        // Gabungkan data berdasarkan token yang sama
        $mergedHistories = $histories->groupBy('token')->map(function ($group) {
            return [
                'token' => $group->first()->token,
                'date' => $group->first()->date,
                'product_id' => $group->first()->product_id,
                'note' => $group->first()->note,
                'total' => $group->sum('total'),
                'quantity' => $group->sum('quantity'),
                'status' => $group->first()->status,
                'table' => $group->first()->table,
                'user_id' => $group->first()->user->name,
            ];
        });

        return view('admin.history.index', [
            'histories' => $mergedHistories,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    }
}
