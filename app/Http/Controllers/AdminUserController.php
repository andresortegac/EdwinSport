<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    private array $managedRoles = ['admin', 'superadmin', 'developer'];

    public function create()
    {
        $admins = User::whereIn('role', $this->managedRoles)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('crear_admin.crear_usuario', compact('admins'));
    }

    public function index()
    {
        $admins = User::whereIn('role', $this->managedRoles)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('crear_admin.crear_usuario', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:80',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
            'role' => 'admin',
        ]);

        return redirect()->route('crear_usuario')
            ->with('success', 'Usuario administrador creado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (in_array($user->role, ['superadmin', 'developer'], true)) {
            return redirect()->route('crear_usuario')
                ->with('error', 'No puedes eliminar una cuenta protegida.');
        }

        if (Auth::id() === $user->id) {
            return redirect()->route('crear_usuario')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('crear_usuario')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::findOrFail($id);

        if (in_array($user->role, ['superadmin', 'developer'], true) && Auth::user()?->role !== 'superadmin') {
            return redirect()->route('crear_usuario')
                ->with('error', 'No tienes permisos para actualizar esta cuenta.');
        }

        $user->password = $request->password;
        $user->save();

        return redirect()->route('crear_usuario')
            ->with('success', 'Contrasena actualizada correctamente.');
    }
}
