document.querySelectorAll('.js-show-password').forEach(x => {
    x.addEventListener('click', function (e) {
        e.preventDefault();
        let passwordInput = this.parentElement.querySelector('input');
        let type = passwordInput.type;
        switch (type) {
            case 'password': {
                passwordInput.type = 'text';
                return;
            }
            case 'text': {
                passwordInput.type = 'password';
                return;
            }
        }
    });
});
