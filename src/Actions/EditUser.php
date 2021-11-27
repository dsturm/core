<?php

namespace Waterhole\Actions;

use Illuminate\Support\Collection;
use Waterhole\Models\User;

class EditUser extends Link
{
    public ?array $context = [null, 'admin'];

    public function name(): string
    {
        return 'Edit';
    }

    public function icon(Collection $items): ?string
    {
        return 'heroicon-o-pencil';
    }

    public function appliesTo($item): bool
    {
        return $item instanceof User;
    }

    public function authorize(?User $user, $item): bool
    {
        return $user && $user->can('update', $item);
    }

    public function link($item)
    {
        return $item->edit_url;
    }
}
