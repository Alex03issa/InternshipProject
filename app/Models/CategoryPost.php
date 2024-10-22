<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = 'category_post';

    protected $fillable = [
        'post_id', 
        'category_id', 
        'section',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
