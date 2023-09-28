<?php

namespace App\Models;

use App\Contracts\Models\MediaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model implements MediaInterface
{
    use HasFactory;

    protected $fillable = [
        'image_path'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'media_post');
    }

    public function getUrl()
    {
        return Storage::disk('public')->url($this->image_path);
    }
}
