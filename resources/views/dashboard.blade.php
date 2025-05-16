@extends('layouts.app')

@section('title', 'Painel de Controle')

@section('content')
    <script>
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/';
        }

        const payload = JSON.parse(atob(token.split('.')[1]));
        const expiration = payload.exp * 1000;

        if (Date.now() >= expiration) {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/';
        }

        window.user = JSON.parse(localStorage.getItem('user'));
    </script>
    @include('components.dashboard.menu')
    @if(isset($user) && $user->isAdmin())
        @include('components.dashboard.users-crud')
    @endif
@endsection
