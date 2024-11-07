<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;
use Carbon\Carbon;

class UpdateAdStatus extends Command
{
    protected $signature = 'ads:update-status';
    protected $description = 'Update the active status of ads based on start and end dates';

    public function handle()
    {
        $today = Carbon::now();

        Ad::all()->each(function ($ad) use ($today) {
            if ($ad->start_date && $today->greaterThanOrEqualTo($ad->start_date) &&
                (!$ad->end_date || $today->lessThanOrEqualTo($ad->end_date))) {
                $ad->update(['active' => true]);
            } else {
                $ad->update(['active' => false]);
            }
        });

        $this->info('Ad statuses have been updated based on start and end dates.');
    }
}
