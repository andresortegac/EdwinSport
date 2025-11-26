<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Muestra el formulario login
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('LOGIN.login');
    }

    // Procesa el login con usuarios en BD
    public function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|email',
                'password' => 'required'
            ],
            [
                'username.required' => 'El usuario es obligatorio.',
                'username.email' => 'Debe ser un correo válido.',
                'password.required' => 'La contraseña es obligatoria.',
            ]
        );

        $credentials = [
            'email' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('register');
        }

        return back()->withErrors([
            'username' => 'Usuario o contraseña incorrectos.'
        ])->withInput();
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('register');
    }
}
