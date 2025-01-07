<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserVerify;

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
        echo "Halo token anda adalah $token";
    }
}
