<?php

namespace Waterhole\Actions;

use Illuminate\Support\Collection;
use Waterhole\Models\Model;
use Waterhole\Models\ReactionType;
use Waterhole\Models\User;

class EditReactionType extends Link
{
    public function appliesTo(Model $model): bool
    {
        return $model instanceof ReactionType;
    }

    public function authorize(?User $user, Model $model): bool
    {
        return $user && $user->can('reaction-type.edit', $model);
    }

    public function label(Collection $models): string
    {
        return __('waterhole::system.edit-link');
    }

    public function icon(Collection $models): string
    {
        return 'tabler-pencil';
    }

    public function url(Model $model): string
    {
        return $model->edit_url;
    }

    public function attributes(Collection $models): array
    {
        return ['data-turbo-frame' => 'modal'];
    }
}
