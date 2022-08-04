<?php

namespace Waterhole\Actions;

use Illuminate\Support\Collection;
use Waterhole\Models\Model;
use Waterhole\Models\Post;
use Waterhole\Models\User;

class EditPost extends Link
{
    public function appliesTo(Model $model): bool
    {
        return $model instanceof Post;
    }

    public function authorize(?User $user, Model $model): bool
    {
        return $user && $user->can('post.edit', $model);
    }

    public function label(Collection $models): string
    {
        return 'Edit Post';
    }

    public function icon(Collection $models): string
    {
        return 'heroicon-o-pencil';
    }

    public function url(Model $model): string
    {
        return $model->edit_url;
    }
}
