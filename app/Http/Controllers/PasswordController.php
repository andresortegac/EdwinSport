<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;   // ✅ Import Auth
use App\Models\User;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ✅ asegura que siempre hay usuario logueado
    }

    // Formulario para cambiar MI contraseña
    public function editMy()
    {
        return view('passwords.edit-my');
    }

    // Guardar cambio de MI contraseña
    public function updateMy(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        // Verifica mi contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Tu contraseña actual no es correcta.'
            ]);
        }

        // Guardar nueva contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('status', 'Tu contraseña fue actualizada.');
    }

    // Formulario para cambiar contraseña del OTRO rol
    public function editOther()
    {
        $me = Auth::user(); // ✅ ya no da error en VS Code

        // Si soy admin, el otro es developer, y viceversa
        $otherRole = $me->role === 'admin' ? 'developer' : 'admin';

        $otherUser = User::where('role', $otherRole)->first();

        if (!$otherUser) {
            return back()->withErrors([
                'role' => "No existe usuario con rol {$otherRole}."
            ]);
        }

        return view('passwords.edit-other', compact('otherUser'));
    }

    // Guardar cambio de contraseña del OTRO rol
    public function updateOther(Request $request)
    {
        $request->validate([
            'my_current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $me = $request->user();

        // Confirma que soy yo con mi contraseña actual
        if (!Hash::check($request->my_current_password, $me->password)) {
            return back()->withErrors([
                'my_current_password' => 'Tu contraseña actual no es correcta.'
            ]);
        }

        // Encuentra al otro usuario (único)
        $otherRole = $me->role === 'admin' ? 'developer' : 'admin';
        $otherUser = User::where('role', $otherRole)->first();

        if (!$otherUser) {
            return back()->withErrors([
                'role' => "No existe usuario con rol {$otherRole}."
            ]);
        }

        // Guarda nueva contraseña del otro
        $otherUser->password = Hash::make($request->password);
        $otherUser->save();

        return back()->with('status', 'Contraseña del otro usuario actualizada.');
    }
}
