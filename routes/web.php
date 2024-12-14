<?php

use App\Http\Controllers\Todo\TodoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/login', [UserController::class, 'login'])->name('login');
Route::post('/user/login', [UserController::class, 'doLogin'])->name('login.post');
Route::get('/user/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/todo', [TodoController::class, 'index'])->name('todo');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.add');
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.delete');
});

