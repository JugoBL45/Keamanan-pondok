<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect()->intended('dashboard');
        }

        return view('auth.login');
    }

    public function proses(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'Username tidak boleh kosong!',
                'password.required' => 'Password tidak boleh kosong!'
            ]
        );

        $email = $request->input('username');
        $password = $request->input('password');

        // $field = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credential = [
            'username' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credential)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user instanceof \App\Models\User) {
                $user->last_login = now();
                $user->save();
            } else {
                dd(get_class($user));
            }

            if ($user) {
                return redirect()->intended('dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            // 'email' => 'Maaf username atau email, atau password Anda salah'
            'username' => 'Oops! Sepertinya kita punya masalah di sini. Kredensialmu tidak sesuai. Yuk, coba lagi! Ingat, pintu ke dunia kami selalu terbuka untukmu dengan kunci yang tepat.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect('/login');
    }
}
