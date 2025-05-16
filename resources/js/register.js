function handleRegister() {
    const name = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;
    const passwordConfirmation = document.getElementById('register-password-confirmation').value;
    const errorDiv = document.getElementById('register-error-message');

    registerUser(name, email, password, passwordConfirmation, errorDiv);
}

async function registerUser(name, email, password, passwordConfirmation, errorDiv) {
    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: name.trim(),
                email: email.trim(),
                password: password.trim(),
                password_confirmation: passwordConfirmation.trim()
            })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error ? `${data.error}: ${data.details}` : 'Erro ao cadastrar');
        }

        closeRegisterModal();
        clearRegisterFields();
        handleRegistrationSuccess(data);

    } catch (error) {
        errorDiv.innerText = error.message;
        console.error('Registration error:', error);
    }
}

function clearRegisterFields() {
    document.getElementById('register-name').value = '';
    document.getElementById('register-email').value = '';
    document.getElementById('register-password').value = '';
    document.getElementById('register-password-confirmation').value = '';
}

function handleRegistrationSuccess(data) {
    localStorage.setItem('token', data.token);
    localStorage.setItem('user', JSON.stringify(data.user));
    window.location.href = '/';
}
