<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPromoController extends Controller
{
    public function edit()
    {
        $promo = Promo::find(1);
        return view('admin.promo.edit', compact('promo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'photo_1' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'photo_2' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'photo_3' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ]);

        $promo = Promo::find(1);

        if ($request->hasFile('photo_1')) {
            $photo_1 = $request->file('photo_1');
            $file_name = time() . '.' . $photo_1->getClientOriginalExtension();
             // simpan nama file ke database
             $promo->photo_1 = $file_name;
             $promo->update();
 
             // simpan file gambar ke storage
             $photo_1->storeAs('public', $file_name);
        }

        if ($request->hasFile('photo_2')) {
            $photo_2 = $request->file('photo_2');
            $file_name = time() . '.' . $photo_2->getClientOriginalExtension();
             // simpan nama file ke database
             $promo->photo_2 = $file_name;
             $promo->update();
 
             // simpan file gambar ke storage
             $photo_2->storeAs('public', $file_name);
        }

        if ($request->hasFile('photo_3')) {
            $photo_3 = $request->file('photo_3');
            $file_name = time() . '.' . $photo_3->getClientOriginalExtension();
             // simpan nama file ke database
             $promo->photo_3 = $file_name;
             $promo->update();
 
             // simpan file gambar ke storage
             $photo_3->storeAs('public', $file_name);
        }

        return redirect()->back()->with('success', 'Promo updated successfully.');
    }
}
