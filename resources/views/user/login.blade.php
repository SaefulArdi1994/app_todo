@extends('layout.app')

@section('title', 'App - Login')

@section('content')

        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Login</h1>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                {{-- Notif --}}
                @include('layout.notif')
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="off" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <button name="submit" type="submit" class="btn btn-primary">Login</button>
                    <a href="{{ route('registrasi')}}">Belum punya akun ? Silahkan melakukan registrasi</a> | <a href="{{ route ('forgotpassword') }}">Lupa Password ?</a>
                </div>
            </form>
        </div>

@endsection
