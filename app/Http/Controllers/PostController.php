<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Interfaces\BaseRepositoryInterface;
use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostsResourse;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostRepositoryInterface $repo)
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    public function index()
    {
        $posts = $this->repo->getAll(6);
        return response([
            'posts' => PostsResourse::collection($posts)
        ]);
    }

    public function store(PostRequest $request)
    {
        $row = $this->repo->create($request->validated());
        return response(['post' => $this->repo->findById($row->id)]);
    }

    public function update(PostRequest $request, $id)
    {
        $this->repo->update($id, $request->validated());
        return response(['post' => $this->repo->findById($id)]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response(['status' => 'success']);
    }

    public function like($id)
    {
        $this->repo->like($id);
        return response(['post' => $this->repo->findById($id)]);
    }
}
