<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Panel Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where the Waterhole Admin Panel will be accessible
    | from. Feel free to change this path to anything you like.
    |
    */

    'path' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Dashboard Widgets
    |--------------------------------------------------------------------------
    |
    | Here you may define any number of dashboard widgets. You're free to
    | use the same widget multiple times in different configurations.
    |
    */

    'widgets' => [
        [
            'component' => Waterhole\Widgets\GettingStarted::class,
            'width' => 100,
        ],
        [
            'component' => Waterhole\Widgets\Feed::class,
            'width' => 50,
            'url' => 'http://waterhole.test/channels/announcements/posts.xml',
            'limit' => 4,
        ],
        [
            'component' => Waterhole\Widgets\LineChart::class,
            'width' => 100 / 3,
            'title' => 'waterhole::admin.dashboard-users-title',
            'model' => Waterhole\Models\User::class,
        ],
        [
            'component' => Waterhole\Widgets\LineChart::class,
            'width' => 100 / 3,
            'title' => 'waterhole::admin.dashboard-posts-title',
            'model' => Waterhole\Models\Post::class,
        ],
        [
            'component' => Waterhole\Widgets\LineChart::class,
            'width' => 100 / 3,
            'title' => 'waterhole::admin.dashboard-comments-title',
            'model' => Waterhole\Models\Comment::class,
        ],
    ],
];
