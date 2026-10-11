<?php

namespace App\Http\Controllers;

use App\Models\GameInfo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class GameInfoController extends Controller
{
   

public function getUserProfile(Request $request, $userId = null): JsonResponse
{
    $user = $request->user();

    // A player can only read their own profile.
    if ($userId !== null && (int) $userId !== (int) $user->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $user->load('gameInfo');

    $response = [
        'username' => $user->username,
        'name' => $user->name,
        'profile_image' => $user->profile_image,
        'timezone' => $user->timezone,
        // Assuming `gameInfo` relation is loaded
        'score' => $user->gameInfo->score ?? 0,
        'retry_times' => $user->gameInfo->retry_times ?? 0,
        'coin' => $user->gameInfo->coin ?? 0,
        'unlocked_skins' => $user->gameInfo ? $user->gameInfo->unlockedIds('unlocked_skins') : [],
        'unlocked_backgrounds' => $user->gameInfo ? $user->gameInfo->unlockedIds('unlocked_backgrounds') : [],
        'unlocked_trophies' => $user->gameInfo ? $user->gameInfo->unlockedIds('unlocked_trophies') : [],
        'background_selected' => $user->gameInfo->background_selected ?? null,
        'ball_skin_selected' => $user->gameInfo->ball_skin_selected ?? null,
    ];

    return response()->json($response, 200);
}

public function apiupdateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate image file
        ]);

        $user = $request->user();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete the old image if it exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store the new image
            $filePath = $request->file('profile_image')->store('profile_images', 'public');

            // Update the user's profile image path
            $user->profile_image = $filePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully.',
                'profile_image_url' => Storage::url($filePath), // URL to access the image
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Profile image not uploaded.'], 400);
    }


    public function resetScoreAndRetryTimes(Request $request)
    {
        // Find the authenticated user's game information
        $gameInfo = GameInfo::where('user_id', $request->user()->id)->first();

        if (!$gameInfo) {
            return response()->json([
                'success' => false,
                'message' => 'Game information not found for the specified user.',
            ], 404);
        }

        // Reset score and retry times
        $gameInfo->score = 0;
        $gameInfo->retry_times = 0;
        $gameInfo->save();

        return response()->json([
            'success' => true,
            'message' => 'Score and retry times have been reset successfully.',
        ]);
    }


    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 400);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }




    public function updateScoreAndCoins(Request $request)
    {
        // Values are deltas added to the totals: non-negative and capped.
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . config('game.max_score_delta'),
            'coin' => 'required|integer|min:0|max:' . config('game.max_coin_delta'),
            'retry_times' => 'required|integer|min:0|max:' . config('game.max_retry_delta'),
        ]);

        $userId = $request->user()->id;
        $gameInfo = GameInfo::where('user_id', $userId)->first();
    
        if (!$gameInfo) {
            return response()->json([
                'message' => 'Game information not found for this user.',
            ], 404);
        }
    
        // Update the game info
        $gameInfo->score += $validated['score'];
        $gameInfo->coin += $validated['coin'];
        $gameInfo->retry_times += $validated['retry_times'];
        $gameInfo->save();
    
        return response()->json([
            'message' => 'Score, coins, and retry times updated successfully.',
            'data' => [
                'user_id' => $userId,
                'score' => $gameInfo->score,
                'coin' => $gameInfo->coin,
                'retry_times' => $gameInfo->retry_times,
            ]
        ]);
    }
    


}
