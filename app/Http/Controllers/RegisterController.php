<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Mostrar formulario de registro
     */
    public function index()
    {
        // Asegúrate que exista:
        // resources/views/REGISTER/register.blade.php
        return view('REGISTER.register');
    }

    /**
     * Guardar usuario registrado
     */
    public function store(Request $request)
    {
        // ✅ Validación básica (ajusta campos según tu form)
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:60', 'unique:users,username'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            // si tienes role en el form, descomenta:
            // 'role' => ['required', 'in:admin,developer'],
        ]);

        // ✅ Crear usuario
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // si manejas roles, puedes poner default:
            'role' => $request->role ?? 'admin',
        ]);

        // ✅ Auto-login después de registrar
        Auth::login($user);

        // ✅ Redirección final (ajusta a tu ruta)
        return redirect()->route('dashboard')
            ->with('status', 'Registro exitoso. ¡Bienvenido!');
    }
}
