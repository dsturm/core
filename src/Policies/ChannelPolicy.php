<?php

namespace Waterhole\Policies;

use Waterhole\Models\Channel;
use Waterhole\Models\PermissionCollection;
use Waterhole\Models\User;

class ChannelPolicy
{
    public function __construct(private PermissionCollection $permissions)
    {
    }

    /**
     * Users can post in a channel if they have permission.
     */
    public function post(User $user, Channel $channel): bool
    {
        return $this->permissions->can($user, 'post', $channel);
    }
}
