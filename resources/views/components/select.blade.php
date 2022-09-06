<div class="select-group">
    <label class="select-group__label" for="{{ $name }}">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="select-group__select"
        {{ $opts }}
    >
        <option value="" class="select-group__select-placeholder">{{ $placeholder }}</option>
        @foreach($options as $k => $v)
            <option value="{{ $k }}" {{ $value == $k ? 'selected' : '' }}>{{ $v }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="validation-error">
        {{ $message }}
    </div>
    @enderror
</div>
