<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    function forgotPasswordForm()
    {
        return view ('user.forgot-password');
    }
}
