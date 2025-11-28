<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PasswordController extends Controller
{
    public function __construct()
    {
        // Solo usuarios logueados pueden entrar
        $this->middleware('auth');
    }

    // =========================
    // 1) CAMBIAR MI CONTRASEÑA
    // =========================

    public function editMy()
    {
        return view('passwords.edit-my');
    }

    public function updateMy(Request $request)
    {
        $request->validate(
            [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'confirmed', 'min:8', 'max:64'],
            ],
            [
                'current_password.required' => 'Debes escribir tu contraseña actual.',
                'password.required' => 'Debes escribir una nueva contraseña.',
                'password.confirmed' => 'La confirmación no coincide.',
                'password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
            ]
        );

        $me = $request->user();

        // Validar contraseña actual
        if (!Hash::check($request->current_password, $me->password)) {
            return back()->withErrors([
                'current_password' => 'Tu contraseña actual no es correcta.'
            ]);
        }

        // Guardar nueva contraseña
        $me->password = Hash::make($request->password);
        $me->save();

        return back()->with('status', 'Tu contraseña fue actualizada.');
    }

    // =========================================
    // 2) CAMBIAR CONTRASEÑA DEL OTRO USUARIO
    // =========================================

    public function editOther()
    {
        $me = Auth::user();

        // Obtener los dos roles existentes en BD
        $roles = User::select('role')->distinct()->pluck('role')->values();

        if ($roles->count() < 2) {
            return back()->withErrors([
                'role' => 'No hay suficientes roles definidos en el sistema.'
            ]);
        }

        // El rol del otro es el que NO es el mío
        $otherRole = $roles->firstWhere(fn($r) => $r !== $me->role);

        $otherUser = User::where('role', $otherRole)->first();

        if (!$otherUser) {
            return back()->withErrors([
                'role' => "No existe el usuario del otro rol."
            ]);
        }

        return view('passwords.edit-other', compact('otherUser'));
    }

    public function updateOther(Request $request)
    {
        $request->validate(
            [
                'my_current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'confirmed', 'min:8', 'max:64'],
            ],
            [
                'my_current_password.required' => 'Debes confirmar tu contraseña actual.',
                'password.required' => 'Debes escribir la nueva contraseña del otro usuario.',
                'password.confirmed' => 'La confirmación no coincide.',
                'password.min' => 'La nueva contraseña debe tener mínimo 8 caracteres.',
            ]
        );

        $me = $request->user();

        // Confirmar que soy yo con mi contraseña actual
        if (!Hash::check($request->my_current_password, $me->password)) {
            return back()->withErrors([
                'my_current_password' => 'Tu contraseña actual no es correcta.'
            ]);
        }

        // Buscar los roles
        $roles = User::select('role')->distinct()->pluck('role')->values();
        $otherRole = $roles->firstWhere(fn($r) => $r !== $me->role);

        $otherUser = User::where('role', $otherRole)->first();

        if (!$otherUser) {
            return back()->withErrors([
                'role' => "No existe el usuario del otro rol."
            ]);
        }

        // Guardar la nueva contraseña al otro
        $otherUser->password = Hash::make($request->password);
        $otherUser->save();

        return back()->with('status', 'Contraseña del otro usuario actualizada.');
    }
}
