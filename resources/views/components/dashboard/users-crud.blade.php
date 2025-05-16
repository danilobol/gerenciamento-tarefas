<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="crud-container">
    <div class="table-header">
        <h3>Gerenciamento de Usuários</h3>
        <button class="new-user-button"
                id="newUserButton" onclick="openRegisterModalPainel()">+ Novo Usuário</button>
    </div>

    <table class="users-table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody id="users-table-body">
        </tbody>
    </table>

    <div class="pagination-container" id="pagination">
    </div>
</div>

@include('components.auth.register-modal')

<script>
    async function loadUsers(page = 1, perPage = 6) {
        try {
            const response = await fetch(`/api/admin/users?page=${page}&perPage=${perPage}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Erro ${response.status}: ${await response.text()}`);
            }

            const { data, meta } = await response.json();
            renderUsers(data);
            renderPagination(meta);
        } catch (error) {
            console.error('Erro ao carregar usuários:', error);
            alert('Erro ao carregar lista de usuários: ' + error.message);
        }
    }

    function renderUsers(users) {
        const tbody = document.getElementById('users-table-body');
        tbody.innerHTML = users.map(user => `
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>
                        <span class="status ${user.status ? 'active' : 'inactive'}">
                            ${user.status ? 'Ativo' : 'Inativo'}
                        </span>
                    </td>
                    <td>
                        <button class="edit-button" data-id="${user.id}">Editar</button>
                        <button class="toggle-status" data-id="${user.id}">
                            ${user.status ? 'Desativar' : 'Ativar'}
                        </button>
                    </td>
                </tr>
            `).join('');
    }

    function renderPagination({ total, currentPage, perPage }) {
        const totalPages = Math.ceil(total / perPage);
        const pagination = document.getElementById('pagination');

        pagination.innerHTML = `
        <div class="pagination-controls">
            ${Array.from({ length: totalPages }, (_, i) => `
                <button
                    class="page-button ${i + 1 === parseInt(currentPage) ? 'active' : ''}"
                    onclick="loadUsers(${i + 1})"
                >
                    ${i + 1}
                </button>
            `).join('')}
        </div>
    `;
    }

    window.loadUsers = loadUsers;
    window.renderUsers = renderUsers;
    window.renderPagination = renderPagination;


    document.addEventListener('DOMContentLoaded', async () => {
        const token = localStorage.getItem('token');
        const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

        await loadUsers(currentPage);
    });

    function openRegisterModalPainel() {
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

            clearRegisterFields();
            closeRegisterModal();
            await loadUsers();
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
</script>

<style>
    .crud-container {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }

    .users-table th,
    .users-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .users-table th {
        background-color: #f8f9fa;
    }

    .status {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    .status.active {
        background-color: #c6f6d5;
        color: #22543d;
    }

    .status.inactive {
        background-color: #fed7d7;
        color: #742a2a;
    }

    button {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .edit-button {
        background-color: #ecc94b;
        color: #744210;
        border: none;
        margin-right: 0.5rem;
    }

    .toggle-status {
        background-color: #4299e1;
        color: white;
        border: none;
    }

    .pagination-controls {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .page-button {
        padding: 0.5rem 1rem;
        background-color: #edf2f7;
        border: none;
        border-radius: 0.25rem;
    }

    .page-button.active {
        background-color: #667eea;
        color: white;
    }
</style>
