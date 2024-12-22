@extends('layout.app')

@section('title', 'App - Login')

@section('navbar')
@include('layout.navbar')
@endsection

@section('content')

        <div class="w-50 center border rounded px-3 py-3 mx-auto">
            <h1>Update Data</h1>
            <form action="{{ route('user.updatedata.post') }}" method="POST">
                @csrf
                {{-- Notif --}}
                @include('layout.notif')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ old('name') ? old('name'):Auth::user()->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" disabled name="email" class="form-control" autocomplete="off" value="{{ Auth::user()->email }}">
                </div>
                <h3>Password</h3>
                <div class="form-text">Silahkan masukkan password jika akan melakukan pergantian password</div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password-confirm" id="password-confirm" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>

@endsection

