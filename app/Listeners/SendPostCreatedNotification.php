<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Post;

class SendPostCreatedNotification implements ShouldQueue
{
    private $post;

    public function __construct(
        Post $post
    ) {
        $this->post = $post;
    }

    public function handle(PostCreated $event)
    {
        // TODO implement logic for sending email to subscribers about new post
    }
}
