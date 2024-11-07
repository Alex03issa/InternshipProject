<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Models\Ad;

class PostController extends Controller
{

    public function showPage($categoryTitle)
    {
        $category = Category::where('title', $categoryTitle)->first();
    
        if (!$category) {
            abort(404, 'Category not found.');
        }
        $contactUsPost = Post::where('active', true)
                ->whereHas('categories', function($query) {
                    $query->where('title', 'Contact Us');
                })
                ->with('contentBlocks') 
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->first();


    
        $posts = Post::with(['categories', 'contentBlocks'])
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('title', $category->title);
            })->where('active', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->with('contentBlocks') 
            ->get();

        
        $teamMembers = \App\Models\TeamMember::all();
        $siteStatistics = \App\Models\SiteStatistic::first();
        $ads = Ad::where('active', true)->get();
    
        switch ($categoryTitle) {
            case 'Privacy Policy':
                return view('privacy', compact('category', 'posts', 'contactUsPost'));
            case 'Terms & Conditions':
                return view('terms', compact('category', 'posts', 'contactUsPost'));
            case 'Blog':
                return view('blog', compact('category', 'posts', 'contactUsPost', 'ads'));
            case 'Homepage':
                return view('Homepage', compact('category', 'posts', 'contactUsPost', 'teamMembers','siteStatistics',  'ads' ));
            default:
                abort(404, 'Page not found.');
        }
    }
    
 

}
