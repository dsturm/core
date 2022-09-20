<button
    type="button"
    class="btn btn--transparent btn--icon"
    @if ($format)
        data-action="text-editor#format"
        data-text-editor-format-param="{{ is_array($format) ? json_encode($format) : $format }}"
    @endif
    @if ($hotkey)
        data-hotkey-scope="{{ $id }}"
        data-hotkey="{{ $hotkey }}"
    @endif
>
    <x-waterhole::icon :icon="$icon"/>
    <ui-tooltip>
        {{ $label }}
        @if ($hotkey)
            <small data-text-editor-target="hotkeyLabel">{{ $hotkey }}</small>
        @endif
    </ui-tooltip>
</button>
