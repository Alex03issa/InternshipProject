<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdStatistic;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function trackClick($adId)
    {
        $ad = Ad::findOrFail($adId);
        $statistic = AdStatistic::updateOrCreate(
            ['ad_id' => $adId],
            ['clicks' => \DB::raw('clicks + 1')]
        );
        $statistic->save();

        $ad->calculateBill(); 

        return $ad->ad_url ? redirect($ad->ad_url) : redirect()->back();
    }

    public function trackView($adId)
    {
        $ad = Ad::findOrFail($adId);
        $statistic = AdStatistic::updateOrCreate(
            ['ad_id' => $adId],
            ['views' => \DB::raw('views + 1')]
        );
        $statistic->save();

        $ad->calculateBill(); 
    }


    public function downloadClientReport($adId)
    {
        $ad = Ad::with('adStatistics')->findOrFail($adId);

        // Prepare data for the report
        $data = [
            ['Ad Name', 'Owner', 'Total Views', 'Total Clicks', 'Bill', 'Paid'],
            [$ad->ad_name, $ad->ad_owner, $ad->total_views, $ad->total_clicks, $ad->bill, $ad->paid_status ? 'Yes' : 'No']
        ];

        $data[] = ['Date', 'Views', 'Clicks'];
        foreach ($ad->adStatistics as $statistic) {
            $data[] = [
                $statistic->created_at->format('Y-m-d'),
                $statistic->views,
                $statistic->clicks,
                
            ];
        }

        // Generate CSV file for download
        $filename = 'client_ad_report_' . $ad->id . '.csv';
        $filePath = storage_path("app/public/{$filename}");
        $file = fopen($filePath, 'w');
        
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function downloadAdminReport()
    {
        $ads = Ad::with('adStatistics')->get();

        // Prepare header row for the report
        $data = [
            ['Ad Name', 'Owner', 'Total Views', 'Total Clicks', 'Bill', 'Revenue Collected']
        ];

        foreach ($ads as $ad) {
            $data[] = [
                $ad->ad_name,
                $ad->ad_owner,
                $ad->total_views,
                $ad->total_clicks,
                $ad->bill,
                $ad->revenue
            ];
        }

        $filename = 'all_clients_ad_report.csv';
        $filePath = storage_path("app/public/{$filename}");
        $file = fopen($filePath, 'w');

        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
