<?php

namespace Waterhole\Providers;

use Astrotomic\Twemoji\Twemoji;
use Illuminate\Support\ServiceProvider;
use Waterhole\Extend;

class TwemojiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('waterhole.design.twemoji_base')) {
            Extend\Emoji::provide([static::class, 'twemoji']);
        }
    }

    public static function twemoji(string $text, array $attributes = []): string
    {
        $attributes['class'] = 'twemoji ' . ($attributes['class'] ?? '');

        return Twemoji::text($text)
            ->base(config('waterhole.design.twemoji_base'))
            ->toHtml(null, array_merge(['width' => '', 'height' => ''], $attributes));
    }
}
