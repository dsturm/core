<?php

namespace Waterhole\View\Components;

use Illuminate\View\Component;
use Waterhole\Models\Post;

class PostUnread extends Component
{
    public bool $isNotifiable;

    public function __construct(public Post $post)
    {
        $this->isNotifiable =
            $post->isFollowed() ||
            (!$post->isIgnored() &&
                $post->userState?->mentioned_at > $post->userState?->last_read_at) ||
            ($post->channel->isFollowed() &&
                $post->last_activity_at > $post->channel->userState->followed_at &&
                !$post->userState->last_read_at);
    }

    public function shouldRender()
    {
        return $this->post->isUnread() && (!$this->post->isNew() || $this->isNotifiable);
    }

    public function render()
    {
        return view('waterhole::components.post-unread');
    }
}
