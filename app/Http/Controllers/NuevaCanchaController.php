<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancha;

class NuevaCanchaController extends Controller
{
    public function create()
    {
        return view('canchas.create');
    }

    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string',
            'telefono_contacto' => 'required|string|max:20',
            'hora_apertura' => 'required',
            'hora_cierre' => 'required',
        ]);

        // Guardar los datos
        Cancha::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'ubicacion' => $request->ubicacion,
            'telefono_contacto' => $request->telefono_contacto,
            'hora_apertura' => $request->hora_apertura,
            'hora_cierre' => $request->hora_cierre,
        ]);

        return redirect()->back()->with('success', 'Cancha creada correctamente.');
    }
}
