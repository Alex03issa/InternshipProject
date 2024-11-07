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
        $posts = Post::all();

        foreach ($posts as $post) {
            $post->updateStatusBasedOnConditions();
        }
    }
}
