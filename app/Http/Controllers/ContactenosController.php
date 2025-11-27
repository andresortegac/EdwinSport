<?php

namespace App\Http\Controllers;

use App\Models\Contactenos;
use Illuminate\Http\Request;

class ContactenosController extends Controller
{

    public function contactenos()
    {
        return view('CONTACTENOS.contactenos');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required',
            'nombre_completo' => 'required',
            'documento' => 'required',
            'correo_electronico' => 'required|email',
            'categoria' => 'required',
        ]);

        Contactenos::create($request->all());

        return back()->with('success', 'Formulario enviado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contactenos $contactenos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactenos $contactenos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contactenos $contactenos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactenos $contactenos)
    {
        //
    }
}
