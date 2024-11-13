<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserStatistic;

class UserActivityController extends Controller
{
    public function updateCurrentVisit(Request $request)
    {
        if (Auth::check()) {
            $userStatistic = UserStatistic::firstOrCreate(['user_id' => Auth::id()]);
            $userStatistic->current_visit = Carbon::now();
            $userStatistic->save();
        }

        return response()->json(['status' => 'success']);
    }
}
