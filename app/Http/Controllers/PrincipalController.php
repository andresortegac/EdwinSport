<?php

namespace App\Http\Controllers;

class PrincipalController extends Controller
{
    public function index()
    {
        return view('PRINCIPAL.principalView');
    }

    public function about()
    {
        return view('PRINCIPAL.about');
    }
}
