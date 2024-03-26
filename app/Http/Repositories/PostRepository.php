<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Resources\PostsResourse;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * Intialize repo instance to the Post class.
     *
     * @param Post $repo 
     */
    public function __construct(Post $repo)
    {
        parent::__construct($repo);
    }

    public function getAll($paginate = null)
    {
        $rows = $this->repo->withCount('likes', 'comments', 'shares', 'views')->with('comments')->latest();
        return $paginate ? $rows->paginate($paginate) : $rows->get();
    }

    public function create(array $data)
    {
        $this->repo = parent::create($data);
        $this->attachImage();
        return $this->repo;
    }

    public function update(int $id, array $data)
    {
        $this->repo = parent::update($id, $data);
        $this->attachImage();
    }

    public function attachImage()
    {
        if (request()->file('image')) {
            $this->repo->attachments()->create([
                'path' => request('image'),
                'type' => 'image'
            ]);
        }
    }

    public function like(int $id)
    {
        $this->repo = $this->repo->findOrFail($id);
        $is_liked = $this->repo->is_liked;
        $is_liked ? $this->repo->likes()->detach(auth()->id()) : $this->repo->likes()->attach(auth()->id());
    }

    public function findById(int $id)
    {
        return new PostsResourse(
            $this->repo->withCount('likes', 'comments', 'shares', 'views')
                ->with('comments')
                ->findOrFail($id)
        );
    }

    public function addComment(int $id)
    {
        $this->repo->findOrFail($id)->comments()->create([
            'user_id' => auth()->id(),
            'comment' => request()->comment
        ]);
    }

    public function deleteComments(int $id , array $commentIds){
        $this->repo->findOrFail($id)->comments()->whereIn('id', $commentIds)->delete();
    }
}
