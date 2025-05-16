<nav class="dashboard-menu">
    <div class="menu-container">
        <div class="menu-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="menu-logo">
            <h2 class="menu-title">Painel de Controle</h2>
        </div>

        <div class="menu-items">
            <button class="menu-item active" data-section="users">
                <i class="fas fa-users"></i>
                <span>Usuários</span>
            </button>
            <button class="menu-item" data-section="tasks">
                <i class="fas fa-tasks"></i>
                <span>Tarefas</span>
            </button>
        </div>

        <div class="menu-footer">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <div>
                    <strong>{{$user->name}}</strong>
                    <small>{{$user->email}}</small>
                </div>
            </div>
            <button class="logout-button" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sair</span>
            </button>
        </div>
    </div>
</nav>

<style>
    .dashboard-menu {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 15px rgba(0,0,0,0.1);
    }

    .menu-container {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .menu-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .menu-logo {
        width: 40px;
        margin-bottom: 0.5rem;
    }

    .menu-title {
        font-size: 1.25rem;
        margin: 0;
        color: white;
    }

    .menu-items {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .menu-item {
        background: none;
        border: none;
        color: rgba(255,255,255,0.8);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .menu-item:hover {
        background: rgba(255,255,255,0.1);
        color: white;
    }

    .menu-item.active {
        background: rgba(255,255,255,0.15);
        color: white;
        font-weight: bold;
    }

    .menu-item i {
        width: 20px;
        text-align: center;
    }

    .menu-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 1rem;
    }

    .user-info {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .user-info i {
        font-size: 2rem;
    }

    .user-info div {
        line-height: 1.3;
    }

    .logout-button {
        background: rgba(255,255,255,0.1);
        color: white;
        border: none;
        width: 100%;
        padding: 0.75rem;
        border-radius: 0.5rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .logout-button:hover {
        background: rgba(255,255,255,0.2);
    }

    /* Adicione no layout principal */
    main {
        margin-left: 250px;
        padding: 2rem;
    }
</style>

<script>
    function logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '/';
    }
</script>
