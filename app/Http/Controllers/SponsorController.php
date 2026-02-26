<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function media(string $path)
    {
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

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

        // Crear sponsor (name + image son columnas reales en BD)
        Sponsor::create([
            'nombre' => $data['nombre'],
            'image'  => $path,
            'url'    => $data['url'] ?? null,
        ]);

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Patrocinador creado correctamente.');
    }
}
