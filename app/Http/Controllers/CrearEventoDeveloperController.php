<?php

namespace App\Http\Controllers;

use App\Models\Event;   // ✅ tu modelo real
use Illuminate\Http\Request;

class CrearEventoDeveloperController extends Controller
{
    public function index()
    {
        // Traer todos los eventos ordenados por el más reciente
        $eventos = Event::latest()->get();

        // Mandarlos a la vista con el nombre EXACTO: eventos
        return view('events.crear-eventodeveloper', [
            'eventos' => $eventos
        ]);
    }
}
