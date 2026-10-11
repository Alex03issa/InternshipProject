<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skin;
use App\Models\Background;
use App\Models\GameInfo;
use Illuminate\Support\Facades\DB;

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
        // The player comes from the Sanctum token, not from the query string.
        $user = $request->user()->load('gameInfo');
        $gameInfo = $user->gameInfo;

        $unlockedSkins = $gameInfo ? $gameInfo->unlockedIds('unlocked_skins') : [];
        $unlockedBackgrounds = $gameInfo ? $gameInfo->unlockedIds('unlocked_backgrounds') : [];

        // Fetch skins and backgrounds
        $skins = Skin::all()->map(function ($skin) use ($gameInfo, $unlockedSkins) {
            return [
                'id' => $skin->id,
                'name' => $skin->skin_name,
                'image' => $skin->skin_image,
                'cost' => $skin->cost,
                'isUnlocked' => in_array($skin->id, $unlockedSkins),
                'isSelected' => $gameInfo && $gameInfo->ball_skin_selected == $skin->id,
            ];
        });

        $backgrounds = Background::all()->map(function ($background) use ($gameInfo, $unlockedBackgrounds) {
            return [
                'id' => $background->id,
                'name' => $background->background_name,
                'image' => $background->background_image,
                'cost' => $background->cost,
                'isUnlocked' => in_array($background->id, $unlockedBackgrounds),
                'isSelected' => $gameInfo && $gameInfo->background_selected == $background->id,
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
        $validated = $request->validate([
            'item_type' => 'required|in:skin,background', // 'skin' or 'background'
            'item_id' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $itemType = $validated['item_type'];
        $itemId = (int) $validated['item_id'];

        $item = $itemType === 'skin' ? Skin::find($itemId) : Background::find($itemId);
        $label = $itemType === 'skin' ? 'Skin' : 'Background';
        $column = $itemType === 'skin' ? 'unlocked_skins' : 'unlocked_backgrounds';

        if (!$item) {
            return response()->json(['success' => false, 'message' => "{$label} not found."], 404);
        }

        return DB::transaction(function () use ($user, $item, $label, $column) {
            // Lock the row so two parallel purchases can't spend the same coins.
            $gameInfo = GameInfo::where('user_id', $user->id)->lockForUpdate()->first();

            if (!$gameInfo) {
                return response()->json(['success' => false, 'message' => 'User or game information not found.'], 404);
            }

            $unlocked = $gameInfo->unlockedIds($column);

            if (in_array($item->id, $unlocked)) {
                return response()->json(['success' => false, 'message' => "{$label} already unlocked."]);
            }

            if ($gameInfo->coin < $item->cost) {
                return response()->json(['success' => false, 'message' => 'Not enough coins.']);
            }

            $unlocked[] = $item->id;
            $gameInfo->coin -= $item->cost;
            $gameInfo->{$column} = $unlocked; // array cast handles the JSON

            if ($gameInfo->save()) {
                return response()->json(['success' => true, 'message' => "{$label} purchased successfully."]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to save game information.']);
        });
    }
    

    public function selectItem(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required|string', // 'skin' or 'background'
            'item_id' => 'required|integer|min:1',
        ]);

        $gameInfo = GameInfo::where('user_id', $request->user()->id)->first();
        $itemType = $validated['item_type'];
        $itemId = (int) $validated['item_id'];

        if (!$gameInfo) {
            return response()->json(['success' => false, 'message' => 'User or game information not found.'], 404);
        }

        if ($itemType === 'skin') {
            if (in_array($itemId, $gameInfo->unlockedIds('unlocked_skins'))) {
                $gameInfo->ball_skin_selected = $itemId;
                $gameInfo->save();

                return response()->json(['success' => true, 'message' => 'Skin selected successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'Skin not unlocked.']);
        } elseif ($itemType === 'background') {
            if (in_array($itemId, $gameInfo->unlockedIds('unlocked_backgrounds'))) {
                $gameInfo->background_selected = $itemId;
                $gameInfo->save();

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
