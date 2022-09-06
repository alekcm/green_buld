<div id="modalFeedback" class="modal-container">
    <div class="modal-container__overlay"></div>

    <div class="modal">
        <div class="modal__close"></div>
        <h3 class="modal__title">
            Задайте нам вопрос
        </h3>
        <form class="form" action="{{ route('web.feedbacks.store') }}" method="POST" id="feedbackForm">
            @csrf
            @method('POST')
            <div class="form__group">
                @component('components.input', [
                    'type' => 'text',
                    'label' => 'ФИО',
                    'name' => 'name',
                    'value' => Auth::user()->name ?? '',
                    'placeholder' => 'Введите ФИО',
                    'opts' => 'required',
                ])@endcomponent
            </div>
            <div class="form__group">
                @component('components.select', [
                    'label' => 'Раздел',
                    'name' => 'section',
                    'value' => '',
                    'options' => App\Models\Config::first()->sections,
                    'placeholder' => 'Выберите раздел',
                    'opts' => 'required',
                ])@endcomponent
            </div>
            <div class="form__group">
                @component('components.select', [
                    'label' => 'Категория закупки',
                    'name' => 'purchasing_category',
                    'value' => '',
                    'options' => App\Models\Config::first()->purchasing_categories,
                    'placeholder' => 'Выберите категорию закупки',
                    'opts' => 'required',
                ])@endcomponent
            </div>
            <div class="form__group">
                @component('components.textarea', [
                    'label' => 'Текст вопроса',
                    'name' => 'question',
                    'value' => '',
                    'placeholder' => 'Введите текст вопроса',
                    'opts' => 'required',
                ])@endcomponent
            </div>

            <div class="form__actions">
                <button type="submit" class="form__button form__button--medium">Отправить</button>
            </div>
        </form>
    </div>
</div>

<div id="modalFeedbackResponse" class="modal-container">
    <div class="modal-container__overlay"></div>
    <div class="modal">
        <div class="modal__close"></div>
        <div class="modal__icon">
            <img class="js-icon" src="{{ asset('img/modal/success.svg') }}" alt="">
        </div>
        <h3 class="js-title modal__title modal__title--center">Ваш вопрос успешно
            отправлен.</h3>
    </div>
</div>

<script>
    const feedbackModal = new Modal('.js-open-modal', 'modalFeedback', 'modalFeedbackResponse');

    $('#feedbackForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let type = "POST";

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: "json",
            encode: true,
            success: function (data) {
                feedbackModal.showModalResponse(data.message,
                    data.code
                        ? "{{ asset('img/modal/error.svg') }}"
                        : "{{ asset('img/modal/success.svg') }}"
                );
            },
            error: function (data) {
                feedbackModal.showModalResponse(data.message, "{{ asset('img/modal/error.svg') }}");
            }
        });
    });
</script>
