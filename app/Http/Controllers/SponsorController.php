<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * Listado de patrocinadores
     * Vista: resources/views/events/sponsors.blade.php
     */
    public function index()
    {
        $sponsors = Sponsor::orderBy('created_at', 'desc')->get();

        return view('events.sponsors', compact('sponsors'));
    }

    /**
     * Formulario para crear un nuevo patrocinador
     * Vista: resources/views/admin/sponsors/create.blade.php
     */
    public function create()
    {
        return view('admin.sponsors.create');
    }

    /**
     * Guardar patrocinador en la base de datos
     */
    public function store(Request $request)
    {
        // Validación de datos
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'logo'   => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'url'    => 'nullable|url',
        ]);

        // Guardar imagen en storage/app/public/sponsors
        $path = $request->file('logo')->store('sponsors', 'public');

        // Crear sponsor
        Sponsor::create([
            'nombre' => $data['nombre'],
            'logo'   => $path,               // columna "logo" en la tabla
            'url'    => $data['url'] ?? null,
        ]);

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Patrocinador creado correctamente.');
    }
}
