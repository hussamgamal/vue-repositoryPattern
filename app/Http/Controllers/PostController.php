<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostsResourse;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(public Post $repo)
    {
    }
    public function index()
    {
        $posts = Post::withCount('views', 'shares', 'likes', 'comments')->with('comments')->latest()->paginate(6);
        $posts = PostsResourse::collection($posts);
        return response([
            'posts' => $posts
        ]);
    }

    public function store(PostRequest $request)
    {
        $this->repo = $this->repo->create([
            ...$request->validated(),
            'user_id' => auth()->id()
        ]);
        if ($request->file('image')) {
            $this->repo->attachments()->create([
                'path' => $request->file('image'),
                'type' => 'image'
            ]);
        }
        return response(['post' => $this->postData()]);
    }

    public function update(PostRequest $request , $id)
    {
        $this->repo = $this->repo->findOrFail($id);
        $this->repo->update([
            ...$request->validated(),
            'user_id' => auth()->id()
        ]);
        if ($request->file('image')) {
            $this->repo->attachments()->create([
                'path' => $request->file('image'),
                'type' => 'image'
            ]);
        }
        return response(['post' => $this->postData()]);
    }

    public function destroy($id){
        $this->repo->findOrFail($id)->delete();
        return response(['status' => 'success']);
    }

    public function like($id)
    {
        $this->repo = $this->repo->findOrFail($id);
        $is_liked = $this->repo->is_liked;
        $is_liked ? $this->repo->likes()->detach(auth()->id()) : $this->repo->likes()->attach(auth()->id());
        return response([
            'post' => $this->postData()
        ]);
    }

    public function postData()
    {
        return new PostsResourse($this->repo->refresh()->loadCount('likes', 'comments', 'shares', 'views')->load('comments'));
    }
}
