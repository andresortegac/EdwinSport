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
     * GET /crear-usuario
     */
    public function index()
    {
        // ✅ Vista corregida (minúsculas)
        // Debe existir: resources/views/register/register.blade.php
        return view('register.register');
    }

    /**
     * Guardar usuario registrado
     * POST /crear-usuario
     */
    public function store(Request $request)
    {
        // ✅ Validación
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:60', 'unique:users,username'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            // Si usas roles en el formulario, descomenta:
            // 'role' => ['required', 'in:admin,developer'],
        ]);

        // ✅ Crear usuario
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            /**
             * ⚠️ IMPORTANTE:
             * Deja esta línea SOLO si tu tabla "users"
             * tiene columna "role".
             * Si NO la tienes, bórrala.
             */
            'role' => $request->role ?? 'admin',
        ]);

        // ✅ Login automático
        Auth::login($user);

        // ✅ Redirección final
        return redirect()->route('dashboard')
            ->with('status', 'Registro exitoso. ¡Bienvenido!');
    }
}
