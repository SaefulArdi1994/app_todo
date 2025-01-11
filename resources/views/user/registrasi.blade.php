@extends('layout.app')

@section('title', 'Registrasi')

@section('content')

        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Registrasi</h1>
            <form action="" method="POST">
                @csrf
                {{-- Notif --}}
                @include('layout.notif')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="off" value="{{ old('email') }}">
                </div>
                <h3>Password</h3>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password-confirm" id="password-confirm" class="form-control">
                </div>
                <div class="mb-3">
                    <button name="submit" type="submit" class="btn btn-primary">Registrasi</button>
                    <a href="{{ route('login')}}">login</a> | <a href="{{ route ('forgotpassword') }}">Lupa Password ?</a>
                </div>
            </form>
        </div>

@endsection

