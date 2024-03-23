<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_liked' => $this->is_liked,
            'user' => $this->user,
            'content' => $this->content,
            'attachments' => $this->attachments,
            'likes' => $this->likes_count,
            'shares' => $this->shares_count,
            'views' => $this->views_count,
            'comments_count' => $this->comments_count,
            'comments' => $this->comments,
            'created_at' => $this->created_at->diffForHumans(),
            'csrf_token' => csrf_token()
        ];
    }
}
