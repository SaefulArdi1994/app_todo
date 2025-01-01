@extends('layout.app')

@section('title', 'App - Reset Password')

@section('content')

        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Reset Pasword</h1>
            <form action="" method="post">
                @csrf
                {{-- Notif --}}
                @include('layout.notif')
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="off" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <button name="submit" type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                </div>
            </form>
        </div>

@endsection
