<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatistic;
use Illuminate\Http\Request;

class AdController extends Controller
{
    // Track ad click
    public function trackClick($id)
    {
        $ad = Ad::findOrFail($id);

        // Record click
        AdStatistic::create([
            'ad_id' => $ad->id,
            'type' => 'click',
        ]);

        // Update revenue if CPC billing is enabled
        if ($ad->use_cpc) {
            $ad->revenue += $ad->cpc_rate;
            $ad->save();
        }

        // Redirect to the ad's URL
        return redirect($ad->ad_url);
    }

    // Track ad view
    public function trackView($id)
    {
        $ad = Ad::findOrFail($id);

        // Record view
        AdStatistic::create([
            'ad_id' => $ad->id,
            'type' => 'view',
        ]);

        // Update revenue if CPM billing is enabled
        if ($ad->use_cpm) {
            $ad->revenue += ($ad->cpm_rate / 1000);
            $ad->save();
        }

        return response()->json(['status' => 'view recorded']);
    }
}
