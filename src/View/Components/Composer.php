<?php

namespace Waterhole\View\Components;

use Illuminate\View\Component;
use Waterhole\Models\Comment;
use Waterhole\Models\Post;
use Waterhole\View\Components\Concerns\Streamable;

class Composer extends Component
{
    use Streamable;

    public function __construct(public Post $post, public ?Comment $parent = null)
    {
        $this->parent = $parent?->exists ? $parent : null;
    }

    public function render()
    {
        return view('waterhole::components.composer');
    }
}
