<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function login()
    {
        return view('user.login');
    }

    function doLogin(Request $request)
    {
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password')
        ];

        if(Auth::attempt($data)) {
            return redirect()->route('todo');
        } else {
            return redirect()->route('login')->withErrors('Username atau password tidak sesuai')->withInput();
        }
    }

    function register()
    {

    }

    function doRegister()
    {

    }

    function updateData()
    {
        return view('user.update-user');
    }

    function doUpdateData()
    {

    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
