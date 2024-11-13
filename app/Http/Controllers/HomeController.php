<?php
namespace App\Http\Controllers;

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\Models\UserStatistic;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function updateLastVisit(Request $request)
    {
        if (Auth::check()) {
            $userStatistic = UserStatistic::firstOrCreate(['user_id' => Auth::id()]);
            
            $userStatistic->last_visit = Carbon::now();
            $userStatistic->save();
        }
        return response()->json(['status' => 'success']);
    }
}
