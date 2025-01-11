@extends('layout.app')

@section('title', 'App - Reset Paasword')

@section('content')

        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Reset Password</h1>
            <form action="{{ route('resetpassword.post') }}" method="POST">
                <input type="hidden" name="token" value="{{ $token }}">
                @csrf
                {{-- Notif --}}
                @include('layout.notif')
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password-confirm" id="password-confirm" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>

@endsection

