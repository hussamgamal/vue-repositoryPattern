<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResourse;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('views', 'shares', 'likes', 'comments')
            ->with('comments', 'attachments')
            ->latest()->paginate(6);
        $posts = PostsResourse::collection($posts);
        return Inertia::render('Home', get_defined_vars());
    }
}
