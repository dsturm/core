<div {{ $attributes->class(['alert', $type ? "alert--$type" : null]) }} role="alert">
    @if ($icon)
        <div class="alert__icon">
            <x-waterhole::icon :icon="$icon"/>
        </div>
    @endif

    <div class="alert__message">
        {{ $slot }}
    </div>

    @if (! empty($action) || $dismissible)
        <div class="alert__actions">
            {{ $action ?? '' }}

            @if ($dismissible)
                <button type="button" class="btn btn--transparent btn--icon" data-action="alerts#dismiss">
                    <x-waterhole::icon icon="heroicon-s-x"/>
                </button>
            @endif
        </div>
    @endif
</div>
