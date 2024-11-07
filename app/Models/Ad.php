<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ad extends Model
{
    use HasFactory;

    // Define the fillable attributes

    protected $fillable = [
        'ad_name',
        'ad_image', 
        'ad_type', 
        'ad_url', 
        'ad_owner', 
        'description',
        'start_date', 
        'end_date', 
        'ad_platform',
        'google_ad_code',
        'active',
        'manual_override',
        'cpc_rate',
        'cpm_rate',
        'use_cpc',
        'use_cpm',
        'revenue',
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

    public function adStatistics()
    {
        return $this->hasMany(AdStatistic::class);
    }

    
    public function getTotalViewsAttribute()
    {
        return $this->adStatistics()->where('type', 'view')->count();
    }

    
    public function getTotalClicksAttribute()
    {
        return $this->adStatistics()->where('type', 'click')->count();
    }

    public function calculateRevenue(): string
    {
        $views = $this->getTotalViewsAttribute();
        $clicks = $this->getTotalClicksAttribute();
        $revenue = 0;

        if ($this->use_cpm && $this->cpm_rate > 0) {
            $revenue += ($views / 1000) * $this->cpm_rate;
        }

        if ($this->use_cpc && $this->cpc_rate > 0) {
            $revenue += $clicks * $this->cpc_rate;
        }

        $this->update(['revenue' => number_format($revenue, 5)]);

        return number_format($revenue, 5);
    }

}
