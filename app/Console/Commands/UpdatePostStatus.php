<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class UpdatePostStatus extends Command
{
    protected $signature = 'posts:update-status';
    protected $description = 'Update post status based on conditions while respecting manual overrides';

    public function handle()
    {
        // Retrieve all posts and update their status based on conditions
        Post::all()->each(function ($post) {
            $post->updateStatusBasedOnConditions();
        });

        $this->info('Post statuses have been updated based on conditions.');
    }
}
