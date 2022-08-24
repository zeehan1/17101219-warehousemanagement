<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppUserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function StoreUserRegistration(Request $request){
        $validateInputData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255',
        ]);
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $role = 'User';
        $hashed_password = Hash::make($password);
        User::insert([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'created_at' => Carbon::now()
        ]);
        AppUserRole::insert([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('login')->with('success', 'You have successfully registered');
    }
}
