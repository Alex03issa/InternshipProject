<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skin;
use App\Models\Background;

class SkinsController extends Controller
{


    public function getAllSkinsAndBackgrounds()
    {
        // Fetch all skins
        $skins = Skin::all()->map(function ($skin) {
            return [
                'id' => $skin->id,
                'name' => $skin->skin_name,
                'image' => $skin->skin_image,
                'cost' => $skin->cost,
            ];
        });

        // Fetch all backgrounds
        $backgrounds = Background::all()->map(function ($background) {
            return [
                'id' => $background->id,
                'name' => $background->background_name,
                'image' => $background->background_image,
                'cost' => $background->cost,
            ];
        });

        return response()->json([
            'success' => true,
            'skins' => $skins,
            'backgrounds' => $backgrounds,
        ]);
    }



    public function getSkinsAndBackgrounds(Request $request)
    {
        $userId = $request->query('user_id'); 
        $user = User::with('gameInfo')->find($userId);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Fetch skins and backgrounds
        $skins = Skin::all()->map(function ($skin) use ($user) {
            return [
                'id' => $skin->id,
                'name' => $skin->skin_name,
                'image' => $skin->skin_image,
                'cost' => $skin->cost,
                'isUnlocked' => in_array($skin->id, json_decode($user->gameInfo->unlocked_skins ?? '[]')),
                'isSelected' => $user->gameInfo->ball_skin_selected == $skin->id,
            ];
        });

        $backgrounds = Background::all()->map(function ($background) use ($user) {
            return [
                'id' => $background->id,
                'name' => $background->background_name,
                'image' => $background->background_image,
                'cost' => $background->cost,
                'isUnlocked' => in_array($background->id, json_decode($user->gameInfo->unlocked_backgrounds ?? '[]')),
                'isSelected' => $user->gameInfo->background_selected == $background->id,
            ];
        });

        return response()->json([
            'success' => true,
            'skins' => $skins,
            'backgrounds' => $backgrounds,
        ]);
    }


    public function purchaseItem(Request $request)
    {
        $user = User::with('gameInfo')->find($request->user_id);
        $itemType = $request->item_type; // 'skin' or 'background'
        $itemId = $request->item_id;
    
        if (!$user || !$user->gameInfo) {
            return response()->json(['success' => false, 'message' => 'User or game information not found.'], 404);
        }
    
        if ($itemType === 'skin') {
            $skin = Skin::find($itemId);
            if (!$skin) {
                return response()->json(['success' => false, 'message' => 'Skin not found.'], 404);
            }
    
            if ($user->gameInfo->coin >= $skin->cost) {
                $user->gameInfo->coin -= $skin->cost;
                $unlockedSkins = json_decode($user->gameInfo->unlocked_skins ?? '[]');
    
                if (!in_array($skin->id, $unlockedSkins)) {
                    $unlockedSkins[] = $skin->id;
                    $user->gameInfo->unlocked_skins = json_encode($unlockedSkins);
                }
    
                if ($user->gameInfo->save()) {
                    $user->gameInfo->refresh(); // Ensure relationship is refreshed
                    return response()->json(['success' => true, 'message' => 'Skin purchased successfully.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to save game information.']);
                }
            }
        } elseif ($itemType === 'background') {
            $background = Background::find($itemId);
            if (!$background) {
                return response()->json(['success' => false, 'message' => 'Background not found.'], 404);
            }
    
            if ($user->gameInfo->coin >= $background->cost) {
                $user->gameInfo->coin -= $background->cost;
                $unlockedBackgrounds = json_decode($user->gameInfo->unlocked_backgrounds ?? '[]');
    
                if (!in_array($background->id, $unlockedBackgrounds)) {
                    $unlockedBackgrounds[] = $background->id;
                    $user->gameInfo->unlocked_backgrounds = json_encode($unlockedBackgrounds);
                }
    
                if ($user->gameInfo->save()) {
                    $user->gameInfo->refresh(); // Ensure relationship is refreshed
                    return response()->json(['success' => true, 'message' => 'Background purchased successfully.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to save game information.']);
                }
            }
        }
    
        return response()->json(['success' => false, 'message' => 'Not enough coins.']);
    }
    

    public function selectItem(Request $request)
    {
        $user = User::with('gameInfo')->find($request->user_id);
        $itemType = $request->item_type; // 'skin' or 'background'
        $itemId = $request->item_id;

        if (!$user || !$user->gameInfo) {
            return response()->json(['success' => false, 'message' => 'User or game information not found.'], 404);
        }

        if ($itemType === 'skin') {
            $unlockedSkins = json_decode($user->gameInfo->unlocked_skins ?? '[]');
            if (in_array($itemId, $unlockedSkins)) {
                $user->gameInfo->ball_skin_selected = $itemId;
                $user->gameInfo->save();

                return response()->json(['success' => true, 'message' => 'Skin selected successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Skin not unlocked.']);
        } elseif ($itemType === 'background') {
            $unlockedBackgrounds = json_decode($user->gameInfo->unlocked_backgrounds ?? '[]');
            if (in_array($itemId, $unlockedBackgrounds)) {
                $user->gameInfo->background_selected = $itemId;
                $user->gameInfo->save();

                return response()->json(['success' => true, 'message' => 'Background selected successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Background not unlocked.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid item type.']);
    }


    public function getItemById(Request $request)
    {
        $itemType = $request->query('item_type'); // 'skin' or 'background'
        $itemId = $request->query('item_id'); // Retrieve the item ID from the request

        // Validate the input
        if (!$itemType || !$itemId) {
            return response()->json(['success' => false, 'message' => 'Item type and ID are required.'], 400);
        }

        // Determine the model to query based on item type
        if ($itemType === 'background') {
            $item = Background::find($itemId);
        } elseif ($itemType === 'skin') {
            $item = Skin::find($itemId);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid item type.'], 400);
        }

        // Check if the item exists
        if (!$item) {
            return response()->json(['success' => false, 'message' => ucfirst($itemType) . ' not found.'], 404);
        }

        // Return the item details
        return response()->json([
            'success' => true,
            'item' => [
                'id' => $item->id,
                'name' => $itemType === 'background' ? $item->background_name : $item->skin_name,
                'image' => $itemType === 'background' ? $item->background_image : $item->skin_image,
                'cost' => $item->cost,
            ],
        ]);
    }



}
