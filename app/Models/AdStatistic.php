<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id', 'views', 'clicks'
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }
}
