<?php

namespace Waterhole\Views\Components;

use Illuminate\View\Component;
use Waterhole\Feed\PostFeed;
use Waterhole\Models\Channel;

class PostFeedToolbar extends Component
{
    public PostFeed $feed;

    public ?Channel $channel;

    public function __construct(PostFeed $feed, Channel $channel = null)
    {
        $this->feed = $feed;
        $this->channel = $channel;
    }

    public function render()
    {
        return view('waterhole::components.feed-toolbar');
    }
}
