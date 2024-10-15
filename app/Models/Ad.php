<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_name', 'ad_image', 'ad_type', 'ad_url', 'ad_owner', 'start_date', 'end_date'
    ];


    public function statistics()
    {
        return $this->hasMany(AdStatistic::class, 'ad_id');
    }
}
