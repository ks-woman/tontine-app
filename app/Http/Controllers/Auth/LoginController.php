<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (Auth::user()->is_admin) {
            return '/admin/dashboard';
        }
        return '/membre/dashboard';
    }

    public function __construct()
    {
        // Les middlewares sont gérés par les routes
    }
}
