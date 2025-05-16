@extends('layouts.app')

@section('title', 'Login')

@section('content')
    @include('components.auth.login-form')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            if (token) {
                const payload = JSON.parse(atob(token.split('.')[1]));
                const expiration = payload.exp * 1000;

                if (Date.now() < expiration) {
                    window.location.href = '/painel';
                }
            }
        });
    </script>
@endsection
