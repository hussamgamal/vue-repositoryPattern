<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private PostRepositoryInterface $repo)
    {
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['comment' => 'required']);
        $this->repo->addComment($id);
        return response(['post' => $this->repo->findById($id)]);
    }

    public function delete_comments(Request $request, $id)
    {
        $this->repo->deleteComments($id, $request->comment_ids);
        return response(['post' => $this->repo->findById($id)]);
    }
}
