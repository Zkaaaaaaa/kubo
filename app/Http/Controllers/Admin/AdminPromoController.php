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

        $promo = Promo::findOrFail(1);

        if ($request->hasFile('photo_1')) {
            // Delete old photo_1 if exists using Storage facade
            if ($promo->photo_1 && Storage::disk('public')->exists($promo->photo_1)) {
                Storage::disk('public')->delete($promo->photo_1);
            }

            $photo_1 = $request->file('photo_1');
            $file_name = $promo->name . '-' . time() . '.' . $photo_1->getClientOriginalExtension();

            // Store the new file using Storage facade
            $photo_1->storeAs('', $file_name, 'public');

            // Save file name to database
            $promo->photo_1 = $file_name;
            $promo->save();
        }
        if ($request->hasFile('photo_2')) {
            // Delete old photo_2 if exists using Storage facade
            if ($promo->photo_2 && Storage::disk('public')->exists($promo->photo_2)) {
                Storage::disk('public')->delete($promo->photo_2);
            }

            $photo_2 = $request->file('photo_2');
            $file_name = $promo->name . '-' . time() . '.' . $photo_2->getClientOriginalExtension();

            // Store the new file using Storage facade
            $photo_2->storeAs('', $file_name, 'public');

            // Save file name to database
            $promo->photo_2 = $file_name;
            $promo->save();
        }
        if ($request->hasFile('photo_3')) {
            // Delete old photo_3 if exists using Storage facade
            if ($promo->photo_3 && Storage::disk('public')->exists($promo->photo_3)) {
                Storage::disk('public')->delete($promo->photo_3);
            }

            $photo_3 = $request->file('photo_3');
            $file_name = $promo->name . '-' . time() . '.' . $photo_3->getClientOriginalExtension();

            // Store the new file using Storage facade
            $photo_3->storeAs('', $file_name, 'public');

            // Save file name to database
            $promo->photo_3 = $file_name;
            $promo->save();
        }
        return redirect()->back()->with('success', 'Promo updated successfully.');
    }
}
