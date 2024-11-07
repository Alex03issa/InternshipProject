<?php
namespace App\Http\Controllers;

use App\Http\Controllers\PostController;

class HomeController extends Controller
{
    protected $postController;

    public function __construct(PostController $postController)
    {
        $this->postController = $postController;
    }

    public function showHomepageWithVerification()
    {
        if (auth()->check() && auth()->user()->is_verified) {
            
            return $this->postController->showPage('Homepage');
        }

        return redirect()->route('login')->with('error', 'Please verify your email before accessing the homepage.');
    }
}
