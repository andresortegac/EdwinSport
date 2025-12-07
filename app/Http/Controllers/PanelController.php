<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Event;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Event::all(); // O con paginación ->paginate(10)
        return view('usuario.panel', compact('eventos'));
    }
}
