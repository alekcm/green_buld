class Modal {

    constructor(jsClassLinks, modalId, modalResponseId) {
        this.modal = document.getElementById(modalId);
        this.modalOverlay = this.modal.querySelector('.modal-container__overlay')
        this.modalCloseBtn = this.modal.querySelector('.modal__close');

        let object = this;

        [this.modalOverlay, this.modalCloseBtn].forEach(x => {
            x.addEventListener('click', function (e) {
                object.toggleModal(object.modal, 'modal-container--active');
            });
        });

        document.querySelectorAll(jsClassLinks).forEach(x => {
            x.addEventListener('click', function (e) {
                object.toggleModal(object.modal, 'modal-container--active');
            })
        });

        this.modalResponse = document.getElementById(modalResponseId);
        this.modalResponseOverlay = this.modalResponse.querySelector('.modal-container__overlay');
        this.modalResponseCloseBtn = this.modalResponse.querySelector('.modal__close');

        [this.modalResponseOverlay, this.modalResponseCloseBtn].forEach(x => {
            x.addEventListener('click', function (e) {
                object.toggleModal(object.modalResponse, 'modal-container--active');
            });
        });
    }

    toggleModal(modal, activeClass) {
        modal.classList.toggle(activeClass);
        document.querySelector('body').classList.toggle('body-modal--active');
    }

    showModalResponse(title, image) {

        this.modalCloseBtn.dispatchEvent(new Event('click'));

        document.querySelector('body').classList.add("body-modal--active");
        this.modalResponse.classList.add('modal-container--active');
        this.modalResponse.querySelector('.js-title').innerHTML = title;
        this.modalResponse.querySelector('.js-icon').setAttribute('src', image);
    }
}
