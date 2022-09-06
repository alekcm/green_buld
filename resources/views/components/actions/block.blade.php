<form
    action="{{ $url }}"
    method="POST">
    @method('PUT')
    @csrf
    <button type="submit"
            class="action-btn"
    >
        <span class="action-btn__tooltip">
            <div class="action-btn__tooltip-tail-container">
                <div class="action-btn__tooltip-tail"></div>
            </div>
            {{ $is_blocked ? 'Разблокировать' : 'Заблокировать' }}
        </span>
        <img src="{{ asset($is_blocked ? 'img/actions/blocked.svg' : 'img/actions/unblocked.svg') }}"
             alt="{{ $is_blocked ? 'Разблокировать' : 'Заблокировать' }}"
        >
    </button>
</form>
