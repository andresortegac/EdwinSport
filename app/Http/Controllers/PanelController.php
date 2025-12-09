<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Event::all(); // O con paginacion ->paginate(10)
        return view('usuario.panel', compact('eventos'));
    }

    public function destroy($id)
    {
        // Buscar el evento
        $evento = Event::findOrFail($id);

        // Si tiene imagen, eliminarla físicamente del storage
        if ($evento->image && Storage::exists('public/' . $evento->image)) {
            Storage::delete('public/' . $evento->image);
        }

        // Eliminar el evento
        $evento->delete();

        // Redirigir con mensaje de exito
        return redirect()->route('usuario.panel')
                        ->with('success', 'Evento eliminado correctamente.');
    }

    public function edit($id)
    {
        // Buscar el evento
        $evento = Event::findOrFail($id);

        // Retornar la vista de edición con los datos del evento
        return view('events.editar-evento', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        // Buscar el evento
        $evento = Event::findOrFail($id);

        // Validación
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Actualizar datos del evento
        $evento->title = $request->title;
        $evento->description = $request->description;
        $evento->category = $request->category;
        $evento->location = $request->location;
        $evento->start_at = $request->start_at;
        $evento->end_at = $request->end_at;
        $evento->status = $request->status;

        // Si se sube nueva imagen
        if ($request->hasFile('image')) {

            // Eliminar imagen anterior
            if ($evento->image && Storage::exists('public/' . $evento->image)) {
                Storage::delete('public/' . $evento->image);
            }

            // Guardar nueva imagen
            $path = $request->file('image')->store('eventos', 'public');
            $evento->image = $path;
        }

        // Guardar cambios
        $evento->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('usuario.panel')
                        ->with('success', 'Evento actualizado correctamente.');
    }


}
