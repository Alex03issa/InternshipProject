<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'uploaded_file',
        'body',
        'active',
        'published_at',
        'timezone',
        'use_blocks',
    ];

protected $casts = [
        'content_blocks' => 'array', 
];
    
public function contentBlocks()
{
    return $this->hasMany(ContentBlock::class)->orderBy('order', 'asc'); 
}
        
public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id')
                ->withPivot('section') 
                ->withTimestamps(); 
}

}
