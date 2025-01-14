<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class ForgotPasswordController extends Controller
{
    function forgotPasswordForm()
    {
        return view ('user.forgot-password');
    }

    function doForgotPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ],[
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email anda belum terdaftar',
        ]);

        // hapus email lama di password reset token
        UserVerify::where('email', $request->input('email'))->delete();

        $token = Str::uuid();
        $data = [
            'email' => $request->input('email'),
            'token' => $token
        ];

        UserVerify::create($data);

        Mail::send('user.email-reset-password', ['token' => $token],function($message) use ($request) {
            $message->to($request->input('email'));
            $message->subject('Reset Password');
        });

        return redirect()->route('forgotpassword')->with('success', 'Email reset paaword telah dikirimkan. silahkan cek terlebih dahulu')->withInput();

    }

    public function resetPassword($token)
    {
        return view('user.reset-password', compact('token'));
    }

    public function doResetPassword(Request $request)
    {
        $request->validate
        (
            [
                'password' => 'nullable|string|min:6',
                'password-confirm' => 'required_with:password|same:password'
            ], [
                'password.required' => 'Password harus diisikan',
                'password.string' => 'Hanya string yang diperbolehkan',
                'password.min' => 'Password minimim 6 karakter',
                'password-confirm.required_with' => 'Password confirm harus diisi',
                'password-confirm.same' => 'Password tidak sama',
            ]
        );

        $dataUser = UserVerify::where('token', $request->input('token'))->first();
        if(!$dataUser) {
            return redirect()->back()->withInput()->withErrors('Token tidak valid');
        }

        $email = $dataUser->email;
        $data = [
            'password' => bcrypt($request->input('password')),
            'email_verified_at' => Carbon::now()
        ];
        User::where('email', $email)->update($data);

        UserVerify::where('email', $email)->delete();
        return redirect()->route('login')->with('success', 'Password berhasil direset');
    }

}
