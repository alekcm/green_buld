<div class="input-group">
    @isset($label)
        <label class="input-group__label" for="{{ $name }}">{{ $label }}</label>
    @endisset
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $opts }}
        class="input-group__input {{ $class ?? '' }} @error($name)input-group__input--invalid @enderror"
    >
    @error($name)
    <div class="validation-error">
        {{ $message }}
    </div>
    @enderror

    @error($name . '.*')
    <div class="validation-error">
        {{ $message }}
    </div>
    @enderror
</div>
