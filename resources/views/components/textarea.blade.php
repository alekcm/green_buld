<div class="textarea-group">
    <label class="textarea-group__label" for="{{ $name }}">{{ $label }}</label>
    <textarea
        class="textarea-group__textarea @error($name . '.*')textarea-group__textarea--invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}"
    {{ $opts }}
>{{ $value }}</textarea>

    @error($name . '.*')
    <div class="validation-error">
        {{ $message }}
    </div>
    @enderror
</div>
