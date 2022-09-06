<div class="checkbox-group">
    <input
        type="checkbox"
        class="checkbox-group__input"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $value ? 'checked' : '' }}
        {{ $opts }}
    >
    <label for="{{ $name }}" class="checkbox-group__label">
        <span class="checkbox-group__label-span">{{ $label }}</span>
    </label>
</div>
