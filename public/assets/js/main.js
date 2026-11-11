document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('exampleModal');

    // On vérifie que la modale existe sur la page
    if (modal) {

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            document.getElementById('modal-author').textContent =
                button.getAttribute('data-author');

            document.getElementById('modal-phone').textContent =
                button.getAttribute('data-phone');

            document.getElementById('modal-email').textContent =
                button.getAttribute('data-email');

            document.getElementById('modal-seats').textContent =
                button.getAttribute('data-seats');

        });

    }

});