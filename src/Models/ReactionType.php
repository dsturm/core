<?php

namespace Waterhole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Waterhole\Models\Concerns\HasIcon;

class ReactionType extends Model
{
    use HasIcon;

    public static function booting(): void
    {
        static::creating(function (ReactionType $reactionType) {
            $reactionType->position =
                $reactionType->reactionSet->reactionTypes()->max('position') + 1;
        });
    }

    public function reactionSet(): BelongsTo
    {
        return $this->belongsTo(ReactionSet::class);
    }

    public function getEditUrlAttribute(): string
    {
        return route('waterhole.admin.reaction-sets.reaction-types.edit', [
            'reactionSet' => $this->reactionSet,
            'reactionType' => $this,
        ]);
    }
}
