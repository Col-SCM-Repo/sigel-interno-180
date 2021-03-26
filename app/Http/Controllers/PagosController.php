<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function Index()
    {
        return view('pagos.index');
    }
    public function ObtenerAlumnos(Request $request)
    {
        $alumnos=[];
        $string = $request->cadena;
        $anio = AnioAcademico::find($request->anio_id);
        foreach ($anio->Vacantes as $vacante) {
           foreach ($vacante->Matriculas as $matricula) {
                $alumno_aux = $matricula->Alumno->where('MP_ALU_NOMBRES', 'like', '%'.$string.'$')
                                                    ->where('MP_ALU_APELLIDOS', 'like', '%'.$string.'$')
                                                    ->where('MP_ALU_DNI', 'like', '%'.$string.'$')->get();

                    dd($alumno_aux);
                if(isset($alumno_aux)){
                    $alumno=[
                        'cod'
                    ];
                    array_push($alumnos, $alumno);
                }
            }
        }
    }
}

