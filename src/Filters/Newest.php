<?php

namespace Waterhole\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * A filter that sorts results by most recently created.
 */
class Newest extends Filter
{
    public function label(): string
    {
        return __('waterhole::forum.filter-newest');
    }

    public function apply(Builder $query): void
    {
        $query->latest();
    }
}
