<?php

namespace App\Http\Controllers;

class ModuloLogisticaController extends Controller
{
    public function __construct()
    {
    }

    public function index () {
        return view('modulos.logistica.index');
    }

}
