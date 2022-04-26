<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuloNotasController extends Controller
{
    public function AlumnoIndex()
    {
        return view('modulos.notasAcademicas.alumnos.index');
    }
    public function NotasIndex($matricula_id)
    {
        return view('modulos.notasAcademicas.notas.index')->with('matricula_id', $matricula_id);
    }
}
