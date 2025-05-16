<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRegisterModal()">&times;</span>
        <h2>Criar Novo Usuário</h2>
        <div class="error-message" id="register-error-message"></div>

        <form id="registerForm" onsubmit="event.preventDefault(); handleRegister()">
            <input type="text" id="register-name" placeholder="Nome completo" required>
            <input type="email" id="register-email" placeholder="E-mail" required>
            <input type="password" id="register-password" placeholder="Senha" required>
            <input type="password" id="register-password-confirmation" placeholder="Confirme sua senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</div>
