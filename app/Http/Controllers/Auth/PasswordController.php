<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showCreateForm()
    {
        return view('passwordcreation'); // Ensure this view exists
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            Auth::logout();
            return redirect()->route('login')->with('status', 'Password set successfully! Please login.');
        }

        return redirect()->route('login')->with('error', 'Something went wrong. Please try again.');
    }
}
