<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialProviderUser extends Model
{
    use HasFactory;

    protected $table = 'user_social_providers';

    protected $fillable = [
        'provider',
        'provider_id',
        'user_id',
        'last_token',
        'email'
    ];
}
