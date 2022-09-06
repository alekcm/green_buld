<div id="modalForgotPassword" class="modal-container">
    <div class="modal-container__overlay"></div>

    <div class="modal">
        <div class="modal__close"></div>
        <h3 class="modal__title">
            Забыли пароль?
        </h3>
        <form class="form" action="{{ route('forgot-password') }}" method="POST" id="forgotPasswordForm">
            @csrf
            @method('POST')
            <div class="form__group form__group--max-width">
                <div class="form__group-text">
                    На указанную почту будет отправлено письмо с новым паролем для входа
                </div>
            </div>

            <div class="form__group">
                @component('components.input', [
                    'type' => 'email',
                    'label' => 'Почта',
                    'name' => 'email_forgot',
                    'value' => '',
                    'placeholder' => 'Введите почту',
                    'opts' => 'required',
                ])@endcomponent
            </div>

            <div class="form__actions">
                <button type="submit" class="form__button form__button--medium">Отправить</button>
            </div>
        </form>
    </div>
</div>

<div id="modalForgotPasswordResponse" class="modal-container">
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
    const forgotPasswordModal = new Modal('.js-open-forgot-password-modal', 'modalForgotPassword', 'modalForgotPasswordResponse');

    $('#forgotPasswordForm').submit(function (e) {
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
                forgotPasswordModal.showModalResponse(data.message,
                    data.code
                        ? "{{ asset('img/modal/error.svg') }}"
                        : "{{ asset('img/modal/success.svg') }}"
                );
            },
            error: function (data) {
                if (data.status === 422) {
                    let errors = $.parseJSON(data.responseText);
                    $.each(errors.errors, function (key, value) {
                        $('#' + key).addClass('input-group__input--invalid');
                        let errorBlock = $('#' + key).parent().find('.validation-error').get();

                        if (!errorBlock.length) {
                            $('#' + key).parent().append('<div class="validation-error">' + value + '</div>');
                        } else {
                            $(errorBlock).text(value);
                        }
                    });
                }
            }
        });
    });
</script>
