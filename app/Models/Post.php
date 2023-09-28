<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Models\PostInterface;
use App\Models\User;
use App\Models\Media;

class Post extends Model implements PostInterface
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'media_post');
    }
}
