<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="login-box">
    <h1>Entrar no Sistema</h1>
    <div class="error-message" id="error-message"></div>

    <input type="email" id="email" placeholder="E-mail" required>
    <input type="password" id="password" placeholder="Senha" required>
    <button type="button" onclick="login()">Entrar</button>

    <div style="text-align: center; margin-top: 1rem;">
        <button type="button" onclick="openRegisterModal()"
                class="link-button">
            Criar nova conta
        </button>
    </div>
</div>

@include('components.auth.register-modal')

<script>
    async function login() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorDiv = document.getElementById('error-message');
        errorDiv.innerText = '';

        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email.trim(),
                    password: password.trim()
                })
            });

            const data = await response.json();

            if (! response.ok) {
                throw new Error(data.error || 'Erro desconhecido');
            }

            localStorage.setItem('token', data.token);
            localStorage.setItem('user', JSON.stringify(data.user));
            window.location.href = '/painel';

        } catch (error) {
            errorDiv.innerText = error.message;
            console.error('Login error:', error);
        }
    }

    function openRegisterModal() {
        document.getElementById('registerModal').style.display = 'flex';
        document.getElementById('register-error-message').innerText = '';
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').style.display = 'none';
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('registerModal');
        if (event.target === modal) {
            closeRegisterModal();
        }
    });

    function handleRegister() {
        const name = document.getElementById('register-name').value;
        const email = document.getElementById('register-email').value;
        const password = document.getElementById('register-password').value;
        const passwordConfirmation = document.getElementById('register-password-confirmation').value;
        const errorDiv = document.getElementById('register-error-message');

        registerUser(name, email, password, passwordConfirmation, errorDiv);
    }

    async function registerUser(name, email, password, passwordConfirmation, errorDiv, isDashboard = false) {
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

            handleRegistrationSuccess(data, isDashboard);

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
        closeRegisterModal();
        clearRegisterFields();

        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        window.location.href = '/painel';
    }
</script>
