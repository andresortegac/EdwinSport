<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Principal;

class PrincipalController extends Controller
{
    public function index()
    {
        return view('PRINCIPAL.principalView');
    }
}
