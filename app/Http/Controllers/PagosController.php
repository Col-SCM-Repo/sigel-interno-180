<?php

namespace App\Http\Controllers;

use App\AnioAcademico;
use App\Helpers\OrdenarArray;
use App\Pago;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class PagosController extends Controller
{
    private $ordenarArray;
    public function __construct(OrdenarArray $ordenarArray)
    {
        $this->ordenarArray=$ordenarArray;
    }
    public function Index()
    {
        return view('pagos.index');
    }
    public function ObtenerAlumnos(Request $request)
    {
        $alumnos=[];
        $string = mb_strtoupper($request->cadena);
        $anio = AnioAcademico::find($request->anio_id);
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

    public function ObtenerPagosPorCronogramaId(Request $request)
    {
        $pagos=[];
        $pagos_aux= Pago::where('MP_CRO_ID',$request->cronograma_id)->get();
        foreach ($pagos_aux as $pago_aux ) {
            $pago=[
                'pago_id'=>$pago_aux->id(),
                'numero'=>$pago_aux->serie().' - '.$pago_aux->numero(),
                'tipo'=>$pago_aux->TipoComprobante->tipo(),
                'monto'=>$pago_aux->monto(),
                'fecha'=>$pago_aux->fecha(),
                'usuario'=>$pago_aux->Usuario->apellidos().', '.$pago_aux->Usuario->nombres(),
            ];
            array_push($pagos, $pago);
        }
        return response()->json($pagos);
    }
}

