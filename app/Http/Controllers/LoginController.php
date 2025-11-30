<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ✅ Muestra el formulario login
    public function show()
    {
        // Si ya está logueado, redirige según rol
        if (Auth::check()) {

            // ✅ Admins a usuario-panel
            if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                return redirect()->route('usuario.panel');
            }

            // ✅ Developers (y cualquier otro) a register
            return redirect()->route('register');
        }

        // Si no está logueado muestra login
        return view('LOGIN.login');
    }

    // ✅ Procesa login
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:64'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Admins a usuario-panel
            if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                return redirect()->route('usuario.panel');
            }

            // ✅ Developers (y cualquier otro) a register
            return redirect()->route('register');
        }

        return back()->withErrors([
            'email' => 'Usuario o contraseña incorrectos.'
        ])->withInput();
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('principal');
    }
}
