<form
    action="{{ $url }}"
    method="POST">
    @method('DELETE')
    @csrf
    <button type="submit"
            class="action-btn"
    >
        <span class="action-btn__tooltip">
            <div class="action-btn__tooltip-tail-container">
                <div class="action-btn__tooltip-tail"></div>
            </div>
            Удалить
        </span>
        <img src="{{ asset('img/actions/destroy.svg') }}" alt="Удалить">
    </button>
</form>
