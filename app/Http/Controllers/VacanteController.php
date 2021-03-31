<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VacanteController extends Controller
{
    public function Index()
    {
        return view('aulas.index');
    }
}
