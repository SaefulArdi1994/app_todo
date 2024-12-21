<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        return view('user.update-data');
    }

    function doUpdateData(Request $request)
    {
        $request->validate
        (
            [
                'name' => 'required|min:2|max:25',
                'password' => 'nullable|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ], [
                'name.required' => 'Kolom nama wajib diisi',
                'name.min' => 'Minimum karakter nama adalah 2 karakter',
                'name.max' => 'Maksimal karakter nama adalah 25 karakter',
                'password.string' => 'Hanya string yang diperbolehkan',
                'password.min' => 'Password minimim 6 karakter',
                'password-confirm.required_with' => 'Password confirm harus diisi',
                'password-confirm.same' => 'Password-confirm tidak sama',
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'password'  => $request->input('password') ? bcrypt($request->input('password')) : Auth::user()->password
        ];

        User::where('id', Auth::user()->id)->update($data);
        return redirect()->route('user.updatedata')->with('success', 'User berhasil di update');
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
