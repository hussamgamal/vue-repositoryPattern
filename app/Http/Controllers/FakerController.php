<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResourse;
use App\Models\Post;
use App\Models\User;

class FakerController extends Controller
{
    public function index($type)
    {
        return $this->$type();
    }

    public function posts()
    {
        $posts = User::factory()
            ->count(3)
            ->has(Post::factory()->count(2))
            ->create();

        return $posts;
    }
}
