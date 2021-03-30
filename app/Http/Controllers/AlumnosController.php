<?php

namespace App\Http\Controllers;

use App\Alumno;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    public function Index()
    {
        return view('alumnos.index');
    }
    public function ObtenerAlumnos(Request $request)
    {
        $alumnos=[];
        $string = mb_strtoupper($request->cadena);

        $alumnos_aux = Alumno::where('MP_ALU_NOMBRES','like','%'.$string.'%')->where('MP_ALU_APELLIDOS','like','%'.$string.'%')->where('MP_ALU_DNI','like','%'.$string.'%')
        foreach ($anio->Vacantes as $vacante) {
            foreach ($vacante->Matriculas as $matricula) {
               if(strpos($matricula->Alumno->MP_ALU_NOMBRES, $string)||strpos($matricula->Alumno->MP_ALU_APELLIDOS, $string)||strpos($matricula->Alumno->MP_ALU_DNI, $string)){
                //dd($vacante->Grado);
                $alumno_aux = $matricula->Alumno;
                    $alumno=[
                        'matricula_id'=> $matricula->MP_MAT_ID,
                        'nombres'=> $alumno_aux->apellidos() . ', '. $alumno_aux->nombres(),
                        'nivel'=> $vacante->Nivel->nivel(),
                        'seccion'=> $vacante->Grado->grado().'° '. $vacante->Seccion->seccion(),
                        'estado'=>  $matricula->estado(),
                    ];
                    array_push($alumnos, $alumno);
                }
            }
        }
        return response()->json($this->ordenarArray->Descendete($alumnos,'nombres'));
    }
}
