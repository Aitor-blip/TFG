(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false || document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                        document.getElementById('confirm_password').classList.add('is-invalid');
                    }
                } else {
                    document.getElementById('confirm_password').classList.remove('is-invalid');
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();


(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
