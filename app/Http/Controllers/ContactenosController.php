<?php

namespace App\Http\Controllers;

use App\Models\Contactenos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoNotificacion;

class ContactenosController extends Controller
{
    public function contactenos()
    {
        return view('CONTACTENOS.contactenos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'tipo' => 'required',
            'nombre_completo' => 'required',
            'documento' => 'required',
            'correo_electronico' => 'required|email',
            'categoria' => 'required',
        ]);

        // Guardar datos + marcar como NO leído
        $datos = $request->all();
        $datos['leido'] = false;

        $contacto = Contactenos::create($datos);

        // Enviar correo
        Mail::to('edwinsport310@gmail.com')->send(new ContactoNotificacion($datos));

        return back()->with('success', 'Formulario enviado correctamente.');
    }

    /**
     * Show the selected contact entry (and mark it as read)
     */
    public function show($id)
    {
        $contacto = Contactenos::findOrFail($id);

        // Marcar como leído
        if (!$contacto->leido) {
            $contacto->leido = true;
            $contacto->save();
        }

        return view('admin.contactos.show', compact('contacto'));
    }

}
