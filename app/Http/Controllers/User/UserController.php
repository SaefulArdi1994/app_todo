<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            if(Auth::user()->email_verified_at == ''){
                Auth::logout();
                return redirect()->route('login')->withErrors('Email belum terverifikasi, silahkan cek email anda!')->withInput();
            } else {
                return redirect()->route('todo');
            }
        } else {
            return redirect()->route('login')->withErrors('Username atau password tidak sesuai')->withInput();
        }
    }

    function registrasi()
    {
        return view('user.registrasi');
    }

    function doRegistrasi(Request $request)
    {
        $request->validate
        (
            [
                'email' => 'required|string|email:rfc,dns|max:100|unique:users,email',
                'name' => 'required|min:2|max:25',
                'password' => 'nullable|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ], [
                'email.required' => 'Email harus diisi',
                'email.string' => 'Email harus diisi oleh string',
                'email.email' => 'Format email harus valid',
                'email.max' => 'Maksimal email 100 karakter',
                'email.unique' => 'Email sudah terdaftar',
                'name.required' => 'Kolom nama wajib diisi',
                'name.min' => 'Minimum karakter nama adalah 2 karakter',
                'name.max' => 'Maksimal karakter nama adalah 25 karakter',
                'password.string' => 'Hanya string yang diperbolehkan',
                'password.min' => 'Password minimim 6 karakter',
                'password-confirm.required_with' => 'Password confirm harus diisi',
                'password-confirm.same' => 'Password tidak sama',
            ]
        );

        $data = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ];

        User::create($data);

        $cekToken = UserVerify::where('email', $request->input('email'))->first();
        if($cekToken) {
            UserVerify::where('email', $request->input('email'))->delete();
        }
        $token=Str::uuid();
        $data = [
            'email' => $request->input('email'),
            'token' => $token
        ];
        UserVerify::create($data);

        Mail::send('user.email-verification', ['token' => $token],function($message) use ($request) {
            $message->to($request->input('email'));
            $message->subject('Email verification');
        });

        return redirect()->route('registrasi')->with('success', 'Email verifikasi telah dikirimkan. silahkan cek terlebih dahulu')->withInput();
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

    function verifyAccount($token)
    {
        $checkuser = UserVerify::where('token', $token)->first();
        if(!is_null($checkuser)) {
            $email = $checkuser->email;

            $datauser = User::where('email', $email)->first();
            if ($datauser->email_verified_at) {
                $message = 'Akun anda sudah terverifikasi sebelumnya';
            } else {
                $data = [
                    'email_verified_at' => Carbon::now()
                ];
                User::where('email', $email)->update($data);
                Userverify::where('email', $email)->delete();
                $message = "Akun anda sudah terverifikasi,silahkan login";
            }

            return redirect()->route('login')->with('success', $message);
        } else {
            return redirect()->route('login')->withErrors('Link token tidak valid');
        }
    }
}
