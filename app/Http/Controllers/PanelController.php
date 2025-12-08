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

}
