<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index',compact('users'));
    }

  
    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,employee,customer',
                'password' => 'required|min:8',

            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);;
            return redirect()->back()->with('success', 'Berhasil');
        }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,employee,customer',
            'password' => 'nullable|min:8',
        ]); 

        $user = User::find($id);                        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if($request->password){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        return redirect()->back()->with('success', 'Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil hapus ' . $user->name);  
    }
}
