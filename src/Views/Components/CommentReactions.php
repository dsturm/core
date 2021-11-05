<?php

namespace Waterhole\Views\Components;

use Illuminate\View\Component;
use Waterhole\Models\Comment;

class CommentReactions extends Component
{
    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return <<<'blade'
            <x-waterhole::reactions :model="$comment"/>
        blade;
    }
}
