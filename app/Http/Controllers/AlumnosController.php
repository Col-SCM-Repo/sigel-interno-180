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
                'alumno_id'=>$matricula->Alumno->id(),
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
    public function Editar($alumno_id)
    {
        return view('alumnos.editar')->with('alumno_id',$alumno_id);
    }

    public function ObtenerAlumnoPorID(Request $request)
    {
        if ($request->alumno_id!=0) {
            $aux=Alumno::find($request->alumno_id);
            $alumno = [
                'id'=>$aux->id(),
                'nombres'=>$aux->nombres(),
                'apellidos'=>$aux->apellidos(),
                'direccion'=>$aux->direccion(),
                'celular'=>$aux->celular(),
                'telefono'=>$aux->telefono(),
                'genero'=>$aux->genero(),
                'fecha_nacimiento'=>date('Y-m-d', strtotime($aux->fecha_nacimiento())),
                'dni'=>$aux->dni(),
                'pais_id'=>$aux->pais_id(),
                'distrito_nacimiento'=>$aux->distrito_nacimiento(),
                'distrito_residencia'=>$aux->distrito_residencia(),
            ];
        } else {
            $alumno = [
                'id'=>0,
                'nombres'=>'',
                'apellidos'=>'',
                'direccion'=>'',
                'celular'=>'',
                'telefono'=>'',
                'genero'=>'',
                'fecha_nacimiento'=>date('Y-m-d'),
                'dni'=>'',
                'pais_id'=>'',
                'distrito_nacimiento'=>'',
                'distrito_residencia'=>'',
            ];
        }
        return response()->json($alumno);
    }
    public function Guardar(Request $request)
    {
        try {
            $alumno = (object)$request->alumno;
            if ($alumno->id!=0) {
                $aux=Alumno::find($alumno->id);
            } else {
                $aux=new Alumno();
            }
            $aux->MP_ALU_NOMBRES=mb_strtoupper($alumno->nombres);
            $aux->MP_ALU_APELLIDOS=mb_strtoupper($alumno->apellidos);
            $aux->MP_ALU_DIRECCION=mb_strtoupper($alumno->direccion);
            $aux->MP_ALU_CELULAR=$alumno->celular;
            $aux->MP_ALU_TELEFONO=$alumno->telefono;
            $aux->MP_ALU_SEXO=$alumno->genero;
            $aux->MP_ALU_FECHANAC=date('Y-m-d\TH:i:s',strtotime($alumno->fecha_nacimiento));
            $aux->MP_ALU_DNI=$alumno->dni;
            $aux->MP_PAIS_ID=$alumno->pais_id;
            $aux->MP_ALU_UBIGNAC=$alumno->distrito_nacimiento;
            $aux->MP_ALU_UBIGDIR=$alumno->distrito_residencia;
            $aux->save();
        } catch (\Throwable $th) {
            return response()->json($th,401);
        }
    }
}
