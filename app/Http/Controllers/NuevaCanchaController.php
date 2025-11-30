<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subcancha;
use App\Models\Cancha;

class NuevaCanchaController extends Controller
{
    public function create()
    {
        return view('canchas.create');
    }

    public function store(Request $request)
    {
        // VALIDACIÓN BÁSICA SIN "after"
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string',
            'telefono_contacto' => 'nullable|string|max:20',
            'hora_apertura' => 'required|date_format:H:i',
            'hora_cierre' => 'required|date_format:H:i',
            'num_canchas' => 'required|integer|min:1|max:4',
        ]);

        // VALIDACIÓN PERSONALIZADA DE HORAS
        if ($data['hora_cierre'] <= $data['hora_apertura']) {
            return back()->withErrors([
                'hora_cierre' => 'La hora de cierre debe ser mayor que la hora de apertura.'
            ])->withInput();
        }

        DB::transaction(function () use ($data) {

            // Crear cancha principal
            $cancha = Cancha::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'ubicacion' => $data['ubicacion'] ?? null,
                'telefono_contacto' => $data['telefono_contacto'] ?? null,
                'hora_apertura' => $data['hora_apertura'],
                'hora_cierre' => $data['hora_cierre'],
                'num_canchas' => $data['num_canchas'],
            ]);

            // Crear subcanchas Cancha 1...N
            for ($i = 1; $i <= $data['num_canchas']; $i++) {
                Subcancha::create([
                    'cancha_id' => $cancha->id,
                    'nombre' => 'Cancha ' . $i,
                    'activo' => true,
                ]);
            }
        });

        return redirect()->route('canchas.index')
            ->with('success', 'Cancha creada con subcanchas.');
    }
}
