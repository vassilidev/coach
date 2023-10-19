document.addEventListener("DOMContentLoaded", function() {
    let flashMessages = document.querySelectorAll('.flash-message');

    flashMessages.forEach(function(flashMessage) {
        setTimeout(function() {
            flashMessage.classList.remove('show');
            flashMessage.addEventListener('transitionend', function() {
                flashMessage.remove();
            }, { once: true });
        }, 5000);
    });
});
