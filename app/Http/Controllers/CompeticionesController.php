<?php

namespace App\Http\Controllers;

use App\Models\Competicion;
use Illuminate\Http\Request;

class CompeticionesController extends Controller
{

    public function competicion()
    {
        return view('COMPETICION.competicionView');
    }

    public function partidos()
    {
        return view('PARTIDOS.partidosView'); 
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Competicion $competicion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competicion $competicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competicion $competicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competicion $competicion)
    {
        //
    }
}
