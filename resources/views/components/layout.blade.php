<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>{{ $title ? $title.' - ' : '' }}{{ config('waterhole.forum.name') }}</title>

    <script>
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js');

        @if (config('waterhole.design.support_dark_mode'))
            document.documentElement.dataset.theme = localStorage.getItem('theme')
            || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        @endif
    </script>

    @foreach (Waterhole\Extend\Stylesheet::urls(['default', 'default-'.App::getLocale(), ...$assets]) as $url)
        <link href="{{ $url }}" rel="stylesheet" data-turbo-track="reload">
    @endforeach

    @foreach (Waterhole\Extend\Script::urls(['default', 'default-'.App::getLocale(), ...$assets]) as $url)
        <script src="{{ $url }}" defer data-turbo-track="reload"></script>
    @endforeach

    <script>
        window.Waterhole = @json($payload);
    </script>

    {{ $head ?? '' }}

    @components(Waterhole\Extend\DocumentHead::build(), compact('title', 'assets'))
</head>

<body {{ $attributes
    ->class([Auth::check() ? 'logged-in' : 'not-logged-in'])
    ->merge(['data-route' => request()->route()->getName()]) }}>

<div id="waterhole" data-controller="page">
    <a
        href="#main"
        class="skip-link"
    >{{ __('waterhole::system.skip-to-main-content-link') }}</a>

    @components(Waterhole\Extend\LayoutBefore::build())

    <main id="main" tabindex="-1">
        {{ $slot }}
    </main>

    @components(Waterhole\Extend\LayoutAfter::build())
</div>

{{--
    The persistent modal element contains a Turbo Frame which can be targeted to
    display modal content. It uses a Stimulus controller such that when content
    is loaded into the frame, the modal will be shown, or if the response
    does not contain modal frame content, the modal will be hidden.
--}}
<ui-modal
    id="modal-element"
    class="modal"
    hidden
    data-controller="modal"
    data-action="
        turbo:before-stream-render@document->modal#hide
        turbo:before-render@document->modal#hide"
    data-turbo-permanent
>
    {{-- https://github.com/hotwired/turbo/pull/445#issuecomment-995305287 --}}
    <turbo-frame
        data-id="modal"
        data-controller="turbo-frame"
        class="modal__frame"
        data-modal-target="frame"
        data-action="
            turbo:submit-start->modal#loading
            turbo:before-fetch-request->modal#loading
            turbo:frame-render->modal#loaded"
        aria-labelledby="dialog-title"
        disabled
    ></turbo-frame>

    <div class="dialog dialog__body dialog--sm" data-modal-target="loading">
        <x-waterhole::spinner class="spinner--block"/>
    </div>
</ui-modal>

{{--
    The main alerts element. This element is accessible in JavaScript via
    window.Waterhole.alerts. For API information:
    https://github.com/tobyzerner/inclusive-elements/tree/master/src/alerts
--}}
<ui-alerts id="alerts" class="alerts">
    @foreach (['success', 'warning', 'danger'] as $type)
        @if (session($type))
            <x-waterhole::alert :type="$type">
                {!! session($type) !!}
            </x-waterhole::alert>
        @endif
    @endforeach
</ui-alerts>

{{--
    Templates for fetch error alert messages. These are cloned into the
    alerts element whenever there is a Turbo frame error in JavaScript
--}}
@foreach (['forbidden', 'too-many-requests', 'fatal-error'] as $key)
    <template id="{{ $key }}-alert">
        <x-waterhole::alert type="danger">
            {{ __("waterhole::system.$key-message") }}
        </x-waterhole::alert>
    </template>
@endforeach

@foreach (['success', 'warning', 'danger'] as $type)
    <template id="template-alert-{{ $type }}">
        <x-waterhole::alert :$type />
    </template>
@endforeach

<template id="frame-error">
    <div class="placeholder">
        <x-waterhole::icon icon="tabler-alert-circle" class="placeholder__icon"/>
        <p class="h4">{{ __('waterhole::system.fatal-error-heading') }}</p>
        <button class="btn btn--transparent color-accent">
            {{ __('waterhole::system.try-again-button') }}
        </button>
    </div>
</template>

<template id="loading">
    <x-waterhole::spinner class="spinner--block"/>
</template>

</body>
</html>
