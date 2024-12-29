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
        $histories = History::all();
        return view('admin.history.index', compact('histories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|max:100',
        //     'product' => 'required|string',
        //     'total' => 'required|numeric',
        // ]);

        // History::create([
        //     'name' => $request->name,
        //     'date' => now(),
        //     'product' => $request->product,
        //     'total' => $request->total,
        // ]);

        // return redirect()->back()->with('success', 'Berhasil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
