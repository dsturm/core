<?php

namespace Waterhole;

use Illuminate\Support\HtmlString;
use Major\Fluent\Formatters\Number\NumberFormatter;
use Major\Fluent\Formatters\Number\Options;
use Waterhole\Extend\Emoji;
use Waterhole\Support\TimeAgo;

/**
 * Format a number in compact notation.
 */
function compact_number(int|float $number, string $locale = null): string
{
    if ($number >= 100) {
        $locale ??= app()->getLocale();
        $key = 'waterhole::number.compact-number-1'.str_repeat('0', floor(log10($number)));

        if (($format = __($key, [], $locale)) !== $key) {
            [$numberFormat, $unit] = str_split($format, strrpos($format, '0') + 1);
            $split = explode('.', $numberFormat);
            $digits = strlen($split[0]);
            $fractionDigits = count($split) > 1 ? strlen($split[1]) : 0;
            $threshold = pow(10, $digits);

            while ($number >= $threshold) {
                $number /= 10;
            }

            $formattedNumber = (new NumberFormatter($locale ?? app()->getLocale()))
                ->format($number, new Options(maximumFractionDigits: $fractionDigits));

            return $formattedNumber.$unit;
        }
    }

    return (string) $number;
}

function time_ago($then): string
{
    $args = TimeAgo::calculate($then);

    return __('waterhole::time.time-ago', $args);
}

function short_time_ago($then): string
{
    $args = TimeAgo::calculate($then);

    return __('waterhole::time.short-time-ago', $args);
}

function relative_time($then): string
{
    $args = TimeAgo::calculate($then);

    return __('waterhole::time.relative-time', $args);
}

function full_time($date): string
{
    if (! $date instanceof DateTime) {
        $date = new DateTime($date);
    }

    return __('waterhole::time.full-time', [
        'date' => new \Tobyz\Fluent\Types\DateTime($date/*, ['timeZone' => 'Australia/Adelaide']*/)
    ]);
}

/**
 * Replace Emoji characters in a text string.
 */
function emojify(string $text, array $attributes = []): HtmlString|string
{
    return Emoji::emojify($text, $attributes);
}

/**
 * Get the best contrast color for text on a background color.
 */
function get_contrast_color(string $hex): string
{
    $r = hexdec(substr($hex, 1, 2));
    $g = hexdec(substr($hex, 3, 2));
    $b = hexdec(substr($hex, 5, 2));
    $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

    return ($yiq >= 128) ? '#000' : '#fff';
}

/**
 * Resolve a collection of services from the container.
 *
 * Items that do not exist will be logged and skipped.
 */
function resolve_all(array $names, array ...$parameters): array
{
    return array_filter(
        array_map(fn($name) => rescue(fn() => resolve($name, ...$parameters)), $names)
    );
}
