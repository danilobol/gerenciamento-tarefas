window.openRegisterModal = function() {
    document.getElementById('registerModal').style.display = 'flex';
    document.getElementById('register-error-message').innerText = '';
};

window.closeRegisterModal = function() {
    document.getElementById('registerModal').style.display = 'none';
};

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('registerModal');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeRegisterModal();
            }
        });
    }
});
