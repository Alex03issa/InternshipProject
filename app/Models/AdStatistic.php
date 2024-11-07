<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdStatistic extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'type'];

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    protected static function booted()
    {
        static::created(function ($adStatistic) {
            // Recalculate and save revenue for the associated ad after each new statistic
            $adStatistic->ad->calculateRevenue();
        });
    }
}
