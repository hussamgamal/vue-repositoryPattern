<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(public Post $repo)
    {
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['comment' => 'required']);
        $this->repo = $this->repo->findOrFail($id);
        $this->repo->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);
        return response([
            'post' => $this->postData()
        ]);
    }

    public function delete_comments(Request $request, $id)
    {
        $this->repo = $this->repo->findOrFail($id);
        $this->repo->comments()->whereIn('id', $request->comment_ids)->delete();
        return response([
            'post' => $this->postData()
        ]);
    }

    private function postData()
    {
        return (new PostController($this->repo))->postData();
    }
}
