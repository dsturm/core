<div {{ $attributes->class(['field', 'has-error' => $errors->has($name)]) }}>
    @if ($label)
        <label for="{{ $name }}" class="field__label">{{ $label }}</label>
    @endif

    @if ($description)
        <p class="field__description">{{ $description }}</p>
    @endif

    <div class="stack-xs">
        {{ $slot }}

        @error($name)
            <div class="field__status color-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
