<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'image');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->with('user')->latest();
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id');
    }

    public function getIsLikedAttribute()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function views()
    {
        return $this->belongsToMany(User::class, 'post_views', 'post_id', 'user_id');
    }

    public function shares()
    {
        return $this->belongsToMany(User::class, 'post_shares', 'post_id', 'user_id')->withPivot('platform');
    }

    public function attachments()
    {
        return $this->hasMany(PostAttachment::class);
    }
}
