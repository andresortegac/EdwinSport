<?php

namespace App\Http\Controllers;

class PrincipalController extends Controller
{
    public function index()
    {
        return view('principal.principalView');
    }

    public function about()
    {
        return view('principal.about');
    }
}
