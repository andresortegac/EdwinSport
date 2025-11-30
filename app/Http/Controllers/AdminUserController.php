<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{

 public function create()
{
    $admins = User::whereIn('role', ['admin', 'superadmin', 'developer'])
                  ->orderBy('created_at', 'desc')
                  ->get();

    return view('crear_admin.crear_usuario', compact('admins'));
}

   public function index()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])
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
            'password' => $request->password, // ✅ texto plano, cast hashed lo encripta
            'role' => 'admin',
        ]);

        return redirect()->route('crear_usuario')
            ->with('success', '✅ Usuario administrador creado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return redirect()->route('crear_usuario')
                ->with('error', '⚠️ No puedes eliminar un superadmin.');
        }

        if (Auth::id() === $user->id) {
            return redirect()->route('crear_usuario')
                ->with('error', '⚠️ No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('crear_usuario')
            ->with('success', '✅ Usuario eliminado correctamente.');
    }

    // ✅ CAMBIAR CONTRASEÑA (1 input)
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::findOrFail($id);
        $user->password = $request->password; // cast hashed lo encripta
        $user->save();

        return redirect()->route('crear_usuario')
            ->with('success', '✅ Contraseña actualizada correctamente.');
    }
}
