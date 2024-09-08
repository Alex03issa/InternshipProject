<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage without any restrictions.
     *
     * @return \Illuminate\View\View
     */
    public function showHomepage()
    {
        return view('Homepage');
    }

    

    /**
     * Show the homepage only for verified users.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showHomepageWithVerification()
    {
        if (auth()->check() && auth()->user()->is_verified) {
            return view('Homepage');
        }
    
        return redirect()->route('login')->with('error', 'Please verify your email before accessing the homepage.');
    }
    
}