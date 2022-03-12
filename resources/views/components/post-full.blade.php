<article {{ $attributes->class('post-full with-sidebar') }}>
    <div class="post-full__main">
        <header class="post-header">
            @components(Waterhole\Extend\PostHeader::build(), compact('post'))
        </header>

        <div
            class="post-body content"
            data-controller="quotable"
        >
            {{ Waterhole\emojify($post->body_html) }}

            <a
                href="{{ route('waterhole.posts.comments.create', compact('post')) }}"
                class="quotable-button btn btn--tooltip"
                data-turbo-frame="@domid($post, 'comment_parent')"
                data-quotable-target="button"
                data-action="quotable#quoteSelectedText"
                hidden
            >
                <x-waterhole::icon icon="heroicon-o-annotation"/>
                <span>Quote</span>
            </a>
        </div>
    </div>

    <div
        class="sidebar sidebar--sticky"
        style="overflow: visible; margin-top: 4rem; position: sticky; margin-bottom: 0"
    >
        <div class="row gap-xs wrap">
            <x-waterhole::action-menu :for="$post" style="margin-bottom: 1rem;" class="full-width">
                <x-slot name="button">
                    <button type="button" class="btn">
                        <x-waterhole::icon icon="heroicon-o-cog"/>
                        <span>Controls</span>
                        <x-waterhole::icon icon="heroicon-s-chevron-down"/>
                    </button>
                </x-slot>
            </x-waterhole::action-menu>

            @components(Waterhole\Extend\PostFooter::build(), compact('post') + ['interactive' => true])
        </div>
    </div>
</article>
