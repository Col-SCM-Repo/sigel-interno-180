<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Helpers\OrdenarArray;
use App\Matricula;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    protected $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray=$ordenarArray;
    }
    public function Index()
    {
        return view('alumnos.index');
    }
    public function ObtenerAlumnos(Request $request)
    {
        $alumnos=[];
        $string = mb_strtoupper($request->cadena);
        $alumnos_aux = Alumno::where('MP_ALU_NOMBRES','like','%'.$string.'%')->orWhere('MP_ALU_APELLIDOS','like','%'.$string.'%')->orWhere('MP_ALU_DNI','like','%'.$string.'%')->get();
        foreach ($alumnos_aux as $alumno_aux) {
            $alumno=[
                'alumno_id'=> $alumno_aux->id(),
                'nombres'=> $alumno_aux->apellidos() . ', '. $alumno_aux->nombres(),
                'dni'=> $alumno_aux->dni(),
            ];
            array_push($alumnos, $alumno);
        }
        return response()->json($this->ordenarArray->Descendete($alumnos,'nombres'));
    }
    public function ObtenerAlumnosPorAula(Request $request)
    {
        $alumnos =[];
        $matriculas = Matricula::where('MP_VAC_ID', $request->aula_id)->get();
        foreach ($matriculas as $matricula) {
            //dd($matricula->Patentesco->Apoderado);
            $alumno = [
                'matricula_id'=>$matricula->id(),
                'nombres'=>$matricula->Alumno->apellidos().', '.$matricula->Alumno->nombres(),
                'dni'=>$matricula->Alumno->dni(),
                'direccion'=>$matricula->Alumno->direccion(),
                'apoderado'=>[
                    'nombres'=>$matricula->Patentesco->Apoderado->apellidos().', '.$matricula->Patentesco->Apoderado->nombres(),
                    'celular'=>$matricula->Patentesco->Apoderado->celular(),
                    'telefono'=>$matricula->Patentesco->Apoderado->telefono(),
                ]
            ];
            array_push($alumnos, $alumno);
        }
        return response()->json($this->ordenarArray->Ascendente($alumnos, 'nombres'));
    }
}
