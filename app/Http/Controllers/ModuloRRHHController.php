<?php

namespace App\Http\Controllers;

use App\Bd_Reloj;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\ErrorHandler\Debug;

class ModuloRRHHController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('modulos.recursosHumanos.reloj.index');
    }
    public function alumnos()
    {

        return view('modulos.recursosHumanos.reloj.alumnos');
    }

    
    public function getDataReloj(Request $request){

        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        /*
        Tiempo Unix en segundos:
        GMT/UTC
        */
        $request->validate([
            "nivel"=>"required | string | min:1",
            "seccion"=>"required | string | min:1",
            "grado"=>"required | string | min:1",
            "f_inicio"=>"required",
        ]);
        
        $f_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 00:00:00','GMT')->timestamp;
        $f_mediodia = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 12:00:00','GMT')->timestamp;
        $f_fin = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 23:59:59','GMT')->timestamp;


        $departamento = Str::upper($request->nivel.'/'.$request->grado.$request->seccion);

        //Marcaciones de alumnos de ese grado para el dia
        /*Turno */
        $dataRegistros= Bd_Reloj::join('TB_USER', 'TB_EVENT_LOG.nUserID', '=', 'TB_USER.sUserID')
                        ->join('TB_EVENT_DATA', 'TB_EVENT_LOG.nEventIdn', '=', 'TB_EVENT_DATA.nEventIdn')
                        ->join('TB_READER', 'TB_EVENT_LOG.nReaderIdn', '=', 'TB_READER.nReaderIdn')
                        ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
                        ->where('TB_EVENT_LOG.nUserID', '<>', 0)
                        ->whereBetween('TB_EVENT_LOG.nDateTime', [$f_inicio, $f_fin])
                        ->where('TB_USER_DEPT.sDepartment', '=', $departamento)
                        ->get(['TB_EVENT_LOG.nEventLogIdn', 
                                'TB_EVENT_LOG.nDateTime as fecha', 
                                'TB_USER.sUserName as usuario', 
                                'TB_EVENT_DATA.sName as accion',
                                'TB_READER.sName as local',
                                'TB_USER_DEPT.sDepartment as departamento',
                                'TB_USER.nUserIdn as id_usuario'
                            ]);

        //Lista de alumnos
        $alumnos= DB::connection('bio_start')
                    ->table('TB_USER')
                    ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
                    ->where('TB_USER_DEPT.sDepartment',$departamento )
                    ->get([
                        "TB_USER.nUserIdn as id",
                        "TB_USER.sUserName as nombre",
                        "TB_USER_DEPT.sDepartment as nivel",
                    ]);
                        
        /*  Formateando data  */
        $alumnos_asistencia_maniana  = [];
        $alumnos_asistencia_tarde  = [];

        $asist_maniana = 0;
        $asist_tarde = 0;
        foreach ($alumnos as $alumno) {
            $temp_alumno_maniana = (object) [ "id"=> $alumno->id , "nombre"=> $alumno->nombre , "nivel"=> $alumno->nivel , "asistio"=> false ] ; 
            $temp_alumno_tarde = (object) [ "id"=> $alumno->id , "nombre"=> $alumno->nombre , "nivel"=> $alumno->nivel , "asistio"=> false ,] ; 

            foreach ($dataRegistros as $marcacion) {
                if(strpos($marcacion->accion, "Success") != false ){
                    if($marcacion->id_usuario ==$alumno->id ){
                        if($marcacion->fecha < $f_mediodia  ){
                            $temp_alumno_maniana->asistio = true;
                            $temp_alumno_maniana->fecha = gmdate("Y-m-d",$marcacion->fecha);
                            $temp_alumno_maniana->hora = gmdate("h:i:s A",$marcacion->fecha); 
                            $asist_maniana++;
                        }
                        else{
                            $temp_alumno_tarde->asistio = true;
                            $temp_alumno_tarde->fecha = gmdate("Y-m-d",$marcacion->fecha); 
                            $temp_alumno_tarde->hora = gmdate("h:i:s A",$marcacion->fecha);
                            $asist_tarde++;
                        }
                    }
                }
                if($temp_alumno_maniana->asistio && $temp_alumno_tarde->asistio ) break;
            }
            if(!$temp_alumno_maniana->asistio){
                $temp_alumno_maniana->fecha = null;
                $temp_alumno_maniana->hora = null;
            }
            if(!$temp_alumno_tarde->asistio){
                $temp_alumno_tarde->fecha = null;
                $temp_alumno_tarde->hora = null;
            }
            $alumnos_asistencia_maniana[] = $temp_alumno_maniana;
            $alumnos_asistencia_tarde[] = $temp_alumno_tarde;
        }
        return [
            "alumnos_maniana"=>$alumnos_asistencia_maniana,
            "alumnos_tarde"=>$alumnos_asistencia_tarde,
            "count_maniana"=>$asist_maniana,
            "count_tarde"=>$asist_tarde,
        ];
    }

    public function descargarPDF( Request $request, $type )
    {
        $request->validate([
            "nivel"=>"required | string | min:1",
            "seccion"=>"required | string | min:1",
            "grado"=>"required | string | min:1",
            "f_inicio"=>"required",
        ]);

        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        
        $fecha = $request->f_inicio;
        $nivel = $request->nivel;
        $grado = $request->grado;
        $seccion = $request->seccion;
        $departamento = Str::upper($request->nivel.'/'.$request->grado.$request->seccion);
        
        $f_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 00:00:00','GMT')->timestamp;
        $f_mediodia = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 12:00:00','GMT')->timestamp;
        $f_fin = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 23:59:59','GMT')->timestamp;


        $departamento = Str::upper($request->nivel.'/'.$request->grado.$request->seccion);

        //Marcaciones de alumnos de ese grado para el dia
        /*Turno */
        $dataRegistros= Bd_Reloj::join('TB_USER', 'TB_EVENT_LOG.nUserID', '=', 'TB_USER.sUserID')
                        ->join('TB_EVENT_DATA', 'TB_EVENT_LOG.nEventIdn', '=', 'TB_EVENT_DATA.nEventIdn')
                        ->join('TB_READER', 'TB_EVENT_LOG.nReaderIdn', '=', 'TB_READER.nReaderIdn')
                        ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
                        ->where('TB_EVENT_LOG.nUserID', '<>', 0)
                        ->whereBetween('TB_EVENT_LOG.nDateTime', [$f_inicio, $f_fin])
                        ->where('TB_USER_DEPT.sDepartment', '=', $departamento)
                        ->get(['TB_EVENT_LOG.nEventLogIdn', 
                                'TB_EVENT_LOG.nDateTime as fecha', 
                                'TB_USER.sUserName as usuario', 
                                'TB_EVENT_DATA.sName as accion',
                                'TB_READER.sName as local',
                                'TB_USER_DEPT.sDepartment as departamento',
                                'TB_USER.nUserIdn as id_usuario'
                            ]);

        //Lista de alumnos
        $alumnos= DB::connection('bio_start')
                    ->table('TB_USER')
                    ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
                    ->where('TB_USER_DEPT.sDepartment',$departamento )
                    ->get([
                        "TB_USER.nUserIdn as id",
                        "TB_USER.sUserName as nombre",
                        "TB_USER_DEPT.sDepartment as nivel",
                    ]);
                        
        /*  Formateando data  */
        $alumnos_asistencia_maniana  = [];
        $alumnos_asistencia_tarde  = [];

        $asist_maniana = 0;
        $asist_tarde = 0;
        foreach ($alumnos as $alumno) {
            $temp_alumno_maniana = (object) [ "id"=> $alumno->id , "nombre"=> $alumno->nombre , "nivel"=> $alumno->nivel , "asistio"=> false ] ; 
            $temp_alumno_tarde = (object) [ "id"=> $alumno->id , "nombre"=> $alumno->nombre , "nivel"=> $alumno->nivel , "asistio"=> false ,] ; 

            foreach ($dataRegistros as $marcacion) {
                if(strpos($marcacion->accion, "Success") != false ){
                    if($marcacion->id_usuario ==$alumno->id ){
                        if($marcacion->fecha < $f_mediodia  ){
                            $temp_alumno_maniana->asistio = true;
                            $temp_alumno_maniana->fecha = gmdate("Y-m-d",$marcacion->fecha);
                            $temp_alumno_maniana->hora = gmdate("h:i:s A",$marcacion->fecha); 
                            $asist_maniana++;
                        }
                        else{
                            $temp_alumno_tarde->asistio = true;
                            $temp_alumno_tarde->fecha = gmdate("Y-m-d",$marcacion->fecha); 
                            $temp_alumno_tarde->hora = gmdate("h:i:s A",$marcacion->fecha);
                            $asist_tarde++;
                        }
                    }
                }
                if($temp_alumno_maniana->asistio && $temp_alumno_tarde->asistio ) break;
            }
            if(!$temp_alumno_maniana->asistio){
                $temp_alumno_maniana->fecha = null;
                $temp_alumno_maniana->hora = null;
            }
            if(!$temp_alumno_tarde->asistio){
                $temp_alumno_tarde->fecha = null;
                $temp_alumno_tarde->hora = null;
            }
            $alumnos_asistencia_maniana[] = $temp_alumno_maniana;
            $alumnos_asistencia_tarde[] = $temp_alumno_tarde;
        }

        $pdf = PDF::loadView('reportes.pdf.rrhh.alumnos',compact('alumnos_asistencia_maniana', 'alumnos_asistencia_tarde','asist_maniana','asist_tarde','fecha',  'nivel',  'grado',  'seccion'));          
        return $pdf->stream();

        //return $request->all();
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

}
