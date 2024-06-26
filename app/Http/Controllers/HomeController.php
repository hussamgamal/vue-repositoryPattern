<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Repositories\PostRepository;
use App\Http\Resources\PostsResourse;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(public PostRepositoryInterface $repo)
    {
    }
    public function index()
    {
        $posts = $this->repo->getAll(6);
        $posts = PostsResourse::collection($posts);
        return Inertia::render('Home', get_defined_vars());
    }

    public function changeLocale($locale = null)
    {
        if ($locale) {
            app()->setLocale($locale);
            session()->put('currentLocale', $locale);
        } else {
            app()->getLocale() == 'ar' ? app()->setLocale('en') : app()->setLocale('ar');
        }
        return response(['locale' => app()->getLocale()]);
    }
}
