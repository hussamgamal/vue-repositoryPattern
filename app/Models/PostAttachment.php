<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'path', 'type'];

    public function setPathAttribute($file)
    {
        if (is_uploaded_file($file)) {
            $this->attributes['path'] = 'storage/' . $file->store('post_attachments');
        } else {
            $this->attributes['path'] = $file;
        }
    }

    public function getPathAttribute($file)
    {
        return url($file);
    }
}
