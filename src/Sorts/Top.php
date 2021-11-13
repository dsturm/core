<?php

namespace Waterhole\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Waterhole\Models\Post;

class Top extends Sort
{
    const PERIODS = ['year', 'quarter', 'month', 'week', 'day'];

    public function name(): string
    {
        return 'Top';
    }

    public function description(): string
    {
        return 'Description';
    }

    public function apply(Builder $query): void
    {
        $query->orderByDesc('score');

        if ($query->getModel() instanceof Post) {
            $query->orderByDesc('comment_count');
        }

        if ($period = $this->currentPeriod()) {
            $query->whereRaw('created_at > DATE_SUB(NOW(), INTERVAL 1 '.strtoupper($period).')');
        }
    }

    public function currentPeriod(): ?string
    {
        if (in_array($period = request()->query('period'), static::PERIODS)) {
            return $period;
        }

        return null;
    }
}
