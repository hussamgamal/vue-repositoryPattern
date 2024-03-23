<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'comment_id', 'user_id', 'comment'];
    
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'image');
    }

    public function getCreatedAtAttribute($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }
}
