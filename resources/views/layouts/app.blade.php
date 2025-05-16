<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const currentPath = window.location.pathname;

            if (!token && currentPath !== '/') {
                window.location.href = '/';
            }

            if (token) {
                const payload = JSON.parse(atob(token.split('.')[1]));
                const expiration = payload.exp * 1000;

                if (Date.now() >= expiration) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '/';
                }
            }
        });

        function logout() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/';
        }
    </script>
</head>
<body>
@yield('content')
</body>
<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #667eea, #764ba2);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-box {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
    }

    .login-box h1 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
        text-align: center;
    }

    .login-box input {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
    }

    .login-box button {
        width: 100%;
        padding: 0.75rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-box button:hover {
        background-color: #5a67d8;
    }

    .error-message {
        color: red;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .link-button {
        background: none;
        border: none;
        color: #667eea;
        cursor: pointer;
        padding: 0;
        font: inherit;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: rgba(255, 255, 255, 0.94);
        padding: 2rem;
        border-radius: 1rem;
        width: 100%;
        max-width: 400px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .modal-content h2 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
        text-align: center;
    }

    .modal-content input {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        box-sizing: border-box;
    }

    .close {
        position: absolute;
        right: 1rem;
        top: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
    }

    .modal-content button {
        width: 100%;
        padding: 0.75rem;
        background-color: #667eea;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .modal-content button:hover {
        background-color: #5a67d8;
    }

    .close {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        font-size: 1.75rem;
        cursor: pointer;
        color: #666;
        transition: color 0.3s;
    }

    .close:hover {
        color: #333;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .new-user-button {
        background-color: #48bb78;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: background-color 0.3s;
        /*display: none;*/
    }

    .new-user-button:hover {
        background-color: #38a169;
    }

    #registerForm {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .crud-container {
        margin: 20px;
        overflow-x: auto;
    }

    .users-table {
        min-width: 600px;
    }

    .pagination-controls {
        padding: 1rem 0;
    }
</style>
</html>
