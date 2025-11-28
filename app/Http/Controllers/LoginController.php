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
            return view('LOGIN.login');
            // si no tienes dashboard: return redirect()->route('principal');
        }

         // tu vista actual    
    }

    // Procesa el login con usuarios en BD
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'string', 'max:50'],
                'password' => ['required', 'string', 'min:6', 'max:64'],
            ],
            [
                'email.required' => 'El usuario es obligatorio.',
                'email.string'   => 'El usuario no es válido.',
                'email.max'      => 'El usuario no debe superar 50 caracteres.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min'      => 'La contraseña debe tener mínimo 6 caracteres.',
                'password.max'      => 'La contraseña no debe superar 64 caracteres.',
            ]
        );

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

       return redirect()->route('register');

        return back()->withErrors([
            'email' => 'Usuario o contraseña incorrectos.'
        ])->withInput();
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
