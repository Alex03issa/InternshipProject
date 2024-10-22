<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ContentBlock;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts and pass them to the index view
        $posts = Post::all();
        return view('posts.index', compact('posts')); // Adjust the view if needed
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the form to create a new post
        return view('posts.create'); // Adjust the view as per your structure
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'title' => 'required|max:2048',
            'slug' => 'required|max:2048|unique:posts,slug',
            'use_blocks' => 'sometimes|boolean', // Optional toggle for using blocks
            'body' => 'nullable|string', // Body content, nullable if blocks are used
            'content_blocks' => 'nullable|array', // Content blocks must be an array if provided
            'content_blocks.*.type' => 'required_with:content_blocks|string',
            'content_blocks.*.content' => 'required_with:content_blocks|string',
            'content_blocks.*.order' => 'nullable|integer',
        ]);

        // Create a new post with the validated data
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => !$validated['use_blocks'] ? $validated['body'] : null, // Save body if not using blocks
        ]);

        // If content blocks are provided, save them
        if ($validated['use_blocks']) {
            foreach ($validated['content_blocks'] as $block) {
                $post->contentBlocks()->create([
                    'type' => $block['type'],
                    'content' => $block['content'],
                    'order' => $block['order'] ?? null,
                ]);
            }
        }

        // Redirect back to post listing or any relevant route with success
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Show the post view, handling body or content blocks
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Return the form to edit the post
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate the request input for updating
        $validated = $request->validate([
            'title' => 'required|max:2048',
            'slug' => 'required|max:2048|unique:posts,slug,' . $post->id,
            'use_blocks' => 'sometimes|boolean',
            'body' => 'nullable|string',
            'content_blocks' => 'nullable|array',
            'content_blocks.*.type' => 'required_with:content_blocks|string',
            'content_blocks.*.content' => 'required_with:content_blocks|string',
            'content_blocks.*.order' => 'nullable|integer',
        ]);

        // Update the post
        $post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => !$validated['use_blocks'] ? $validated['body'] : null,
        ]);

        // If using blocks, update them
        if ($validated['use_blocks']) {
            $post->contentBlocks()->delete(); // Delete old blocks
            foreach ($validated['content_blocks'] as $block) {
                $post->contentBlocks()->create([
                    'type' => $block['type'],
                    'content' => $block['content'],
                    'order' => $block['order'] ?? null,
                ]);
            }
        }

        // Redirect back or to the post listing with success
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Delete the post
        $post->delete();

        // Redirect back to the post listing with success
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
