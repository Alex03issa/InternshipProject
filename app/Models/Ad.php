<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_name', 'ad_image', 'ad_type', 'ad_url', 'ad_owner', 'description',
        'start_date', 'end_date', 'ad_platform', 'google_ad_code', 'active',
        'manual_override', 'cpc_rate', 'cpm_rate', 'use_cpc', 'use_cpm', 'revenue', 'paid_status'
    ];

    protected $dates = ['start_date', 'end_date'];

    protected static function boot()
    {
        parent::boot();

        // Automatically update `active` based on start_date and end_date if manual_override is false
        static::saving(function ($ad) {
            if (!$ad->manual_override) { 
                $today = Carbon::now();

                if ($ad->start_date && $today->greaterThanOrEqualTo($ad->start_date) &&
                    (!$ad->end_date || $today->lessThanOrEqualTo($ad->end_date))) {
                    $ad->active = true;
                } else {
                    $ad->active = false;
                }
            }
        });
    }

    
    public function calculateBill()
    {
        $bill = 0;

        foreach ($this->adStatistics as $statistic) {
            if ($this->use_cpm && $this->cpm_rate > 0) {
                $bill += ($statistic->views / 1000) * $this->cpm_rate;
            }
            if ($this->use_cpc && $this->cpc_rate > 0) {
                $bill += $statistic->clicks * $this->cpc_rate;
            }
        }

        $this->bill = round($bill, 5);
        $this->save();

        self::updateRevenue();
        
    }


    public static function updateRevenue()
    {
        $ads = Ad::all(); // Retrieve all ads, regardless of paid status

        foreach ($ads as $ad) {
            // Set revenue based on paid status
            $ad->revenue = $ad->paid_status ? $ad->bill : 0;
            $ad->save();
        }
    }



    public function getTotalViewsAttribute()
    {
        return $this->adStatistics()->sum('views');
    }

    public function getTotalClicksAttribute()
    {
        return $this->adStatistics()->sum('clicks');
    }

    public function adStatistics()
    {
        return $this->hasMany(AdStatistic::class);
    }
}
