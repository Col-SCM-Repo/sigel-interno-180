<?php

namespace App\Http\Controllers;

use App\Bd_Reloj;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
Tiempo Unix en segundos:
GMT/UTC
*/

class ModuloRRHHController extends Controller
{
    /* VISTAS */
    public function index()
    {

        return view('modulos.recursosHumanos.reloj.index');
    }

    public function alumnos()
    {
        return view('modulos.recursosHumanos.reloj.alumnos');
    }

    public function alumnosAcademia()
    {
        return view('modulos.recursosHumanos.reloj.alumnos-academia');
    }


    public function empleados()
    {
        return view('modulos.recursosHumanos.reloj.empleados');
    }

    public function verReporteMarcaciones( Request $request)
    {
        $request->validate([
            "personal_id" => "string | min:1 | required",
            "f_inicio" => "string | min:10 | max:10  | required",
            "f_fin" => "string | min:10 | max:10  | required",
        ]);

        $data =  [
            "marcaciones" => self::getMarcacionesPersonal($request->personal_id, $request->f_inicio, $request->f_fin),
            "f_inicio" =>$request->f_inicio,
            "f_fin" => $request->f_fin,
        ];
        return view('modulos.recursosHumanos.reloj.partials.personal-marcaciones')->with("data", (Object) $data);
        //return $data;
    }



    /***************************** API - DEVUELVEN DATOS *****************************/
    public function empleados_search( $param=null ){
        return self::searchListPersonal($param);
    }

    public function getDataReloj(Request $request){
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $request->validate([
            "nivel"=>"required | string | min:1",
            "seccion"=>"required | string | min:1",
            "grado"=>"",
            "f_inicio"=>"required",
        ]);

        $f_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 00:00:00','GMT')->timestamp;
        $f_mediodia = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 13:30:00','GMT')->timestamp;
        $f_fin = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 23:59:59','GMT')->timestamp;

        $departamento = Str::upper($request->nivel.'/'.$request->grado.$request->seccion);

        //Marcaciones de alumnos de ese grado para el dia
        /*Turno */
        $dataRegistros_log= Bd_Reloj::join('TB_USER', 'TB_EVENT_LOG.nUserID', '=', 'TB_USER.sUserID')
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

        $dataRegistros_bak= DB::connection('bio_start')->table('TB_EVENT_LOG_BK')
        ->join('TB_USER', 'TB_EVENT_LOG_BK.nUserID', '=', 'TB_USER.sUserID')
        ->join('TB_EVENT_DATA', 'TB_EVENT_LOG_BK.nEventIdn', '=', 'TB_EVENT_DATA.nEventIdn')
        ->join('TB_READER', 'TB_EVENT_LOG_BK.nReaderIdn', '=', 'TB_READER.nReaderIdn')
        ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
        ->where('TB_EVENT_LOG_BK.nUserID', '<>', 0)
        ->whereBetween('TB_EVENT_LOG_BK.nDateTime', [$f_inicio, $f_fin])
        ->where('TB_USER_DEPT.sDepartment', '=', $departamento)
        ->get(['TB_EVENT_LOG_BK.nEventLogIdn',
                'TB_EVENT_LOG_BK.nDateTime as fecha',
                'TB_USER.sUserName as usuario',
                'TB_EVENT_DATA.sName as accion',
                'TB_READER.sName as local',
                'TB_USER_DEPT.sDepartment as departamento',
                'TB_USER.nUserIdn as id_usuario'
            ]);

        $dataRegistros = [ ...$dataRegistros_log , ...$dataRegistros_bak];

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



    /***************************** PDF CONTROLLER : GENERAR PDFs *****************************/
    public function descargarPDF( Request $request, $type )
    {
        $request->validate([
            "nivel"=>"required | string | min:1",
            "seccion"=>"required | string | min:1",
            "grado"=>"",
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
        $f_mediodia = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 13:30:00','GMT')->timestamp;
        $f_fin = Carbon::createFromFormat('Y-m-d H:i:s', $request->f_inicio.' 23:59:59','GMT')->timestamp;


        $departamento = Str::upper($request->nivel.'/'.$request->grado.$request->seccion);

        //Marcaciones de alumnos de ese grado para el dia
        /*Turno */
        $dataRegistros_log= Bd_Reloj::join('TB_USER', 'TB_EVENT_LOG.nUserID', '=', 'TB_USER.sUserID')
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

        $dataRegistros_bak= DB::connection('bio_start')->table('TB_EVENT_LOG_BK')
        ->join('TB_USER', 'TB_EVENT_LOG_BK.nUserID', '=', 'TB_USER.sUserID')
        ->join('TB_EVENT_DATA', 'TB_EVENT_LOG_BK.nEventIdn', '=', 'TB_EVENT_DATA.nEventIdn')
        ->join('TB_READER', 'TB_EVENT_LOG_BK.nReaderIdn', '=', 'TB_READER.nReaderIdn')
        ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', '=', 'TB_USER_DEPT.nDepartmentIdn')
        ->where('TB_EVENT_LOG_BK.nUserID', '<>', 0)
        ->whereBetween('TB_EVENT_LOG_BK.nDateTime', [$f_inicio, $f_fin])
        ->where('TB_USER_DEPT.sDepartment', '=', $departamento)
        ->get(['TB_EVENT_LOG_BK.nEventLogIdn',
                'TB_EVENT_LOG_BK.nDateTime as fecha',
                'TB_USER.sUserName as usuario',
                'TB_EVENT_DATA.sName as accion',
                'TB_READER.sName as local',
                'TB_USER_DEPT.sDepartment as departamento',
                'TB_USER.nUserIdn as id_usuario'
            ]);

        $dataRegistros = [ ...$dataRegistros_log , ...$dataRegistros_bak];

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

    public function descargarReportePersonal(Request $request){
        $request->validate([
            "personal_id" => "string | min:1 | required",
            "f_inicio" => "string | min:10 | max:10  | required",
            "f_fin" => "string | min:10 | max:10  | required",
        ]);


        $personal = DB::connection('bio_start')
                    ->table('TB_USER')
                    ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', 'TB_USER_DEPT.nDepartmentIdn')
                    ->where('TB_USER.nUserIdn',$request->personal_id )
                    ->get([
                        "TB_USER.nUserIdn as id",
                        "TB_USER.sUserName as nombre",
                        "TB_USER_DEPT.sName",
                        "TB_USER_DEPT.sDepartment as departamento"
                    ]);

        if(!$personal) throw new NotFoundHttpException("No se encontro el usuario");
        $data = (Object) [
            "personal" => $personal[0],
            "marcaciones" => self::getMarcacionesPersonal($request->personal_id, $request->f_inicio, $request->f_fin),
            "f_inicio" =>$request->f_inicio,
            "f_fin" => $request->f_fin,
        ];
        return view('reportes.pdf.rrhh.empleados_marcaciones')->with("data", $data);
    }


    /*********** HELPERS - Metodos para obtener datos - a nivel de la cclase ***********/
    private function getMarcacionesPersonal( $personal_id, $f_inicio, $f_fin ){
        $f_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $f_inicio.' 00:00:00','GMT')->timestamp;
        $f_fin = Carbon::createFromFormat('Y-m-d H:i:s', $f_fin.' 23:59:59','GMT')->timestamp;
        $diaSemana= ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];

        $marcacionesBK = DB::connection('bio_start')
                    ->table('TB_EVENT_LOG_BK')
                    ->join('TB_USER', 'TB_USER.sUserID', 'TB_EVENT_LOG_BK.nUserID')
                    ->join('TB_EVENT_DATA', 'TB_EVENT_LOG_BK.nEventIdn', 'TB_EVENT_DATA.nEventIdn')
                    ->join('TB_READER', 'TB_EVENT_LOG_BK.nReaderIdn', 'TB_READER.nReaderIdn')

                    ->where('TB_USER.nUserIdn', $personal_id )
                    ->where("TB_EVENT_DATA.sName", "like", "%success%")
                    ->whereBetween('TB_EVENT_LOG_BK.nDateTime', [$f_inicio, $f_fin])
                    ->get([
                        "TB_EVENT_LOG_BK.nEventLogIdn",
                        "TB_EVENT_LOG_BK.nDateTime",
                        "TB_EVENT_LOG_BK.nUserID",
                        "TB_USER.nUserIdn",
                        "TB_USER.sUserName",
                        "TB_EVENT_DATA.sName",
                        "TB_READER.sName as nLocal",
                    ]);

        $marcacionesLog = DB::connection('bio_start')
                    ->table('TB_EVENT_LOG')
                    ->join('TB_USER', 'TB_USER.sUserID', 'TB_EVENT_LOG.nUserID')
                    ->join('TB_EVENT_DATA', 'TB_EVENT_LOG.nEventIdn', 'TB_EVENT_DATA.nEventIdn')
                    ->join('TB_READER', 'TB_EVENT_LOG.nReaderIdn', 'TB_READER.nReaderIdn')
                    ->where('TB_USER.nUserIdn', $personal_id )
                    ->where("TB_EVENT_DATA.sName", "like", "%success%")
                    ->whereBetween('TB_EVENT_LOG.nDateTime', [$f_inicio, $f_fin])
                    ->get([
                        "TB_EVENT_LOG.nEventLogIdn",
                        "TB_EVENT_LOG.nDateTime",
                        "TB_EVENT_LOG.nUserID",
                        "TB_USER.nUserIdn",
                        "TB_USER.sUserName",
                        "TB_EVENT_DATA.sName",
                        "TB_READER.sName as nLocal",
                    ]);

        $marcaciones = [...$marcacionesBK, ... $marcacionesLog];

        //Formateando fecha (Formatear)
        foreach ($marcaciones  as $marcacion) {
            $hora = (int) gmdate("H",$marcacion->nDateTime);
            $marcacion->nDay = gmdate("l",$marcacion->nDateTime);
            $marcacion->nDia = $diaSemana [ (int)gmdate("N",$marcacion->nDateTime) -1 ];
            $marcacion->nTurno = $hora>12? "Tarde": "Mañana" ;
            $marcacion->nFecha = gmdate("Y-m-d",$marcacion->nDateTime);
            $marcacion->nHora = gmdate("H:i:s A",$marcacion->nDateTime);
        }
        return $marcaciones;
    }

    private function searchListPersonal($param=" "){
        $data = DB::connection('bio_start')
        ->table('TB_USER')
        ->join('TB_USER_DEPT', 'TB_USER.nDepartmentIdn', 'TB_USER_DEPT.nDepartmentIdn')
        ->where('TB_USER_DEPT.sDepartment', 'like', '%PERSONAL%')
        ->where('TB_USER.sUserName', 'like', "%$param%")
        ->where('TB_USER.sEmail', '0')
        ->orderBy('TB_USER.sUserName')
        ->get(["TB_USER.nUserIdn",
                "TB_USER.sUserName as nombre_empleado",
                "TB_USER.sUserID",
                "TB_USER_DEPT.sName",
                "TB_USER_DEPT.sDepartment as departamento",
                "TB_USER.sEmail as estado"
        ]);
        return $data;
    }

}
/*
    POLITICAS DE ACCESO
        HinicioMañana = 8:00
        HinicioMañanaVigilante = 7:30
        HinicioMañanaAuxiliares = 7:30

        HsalidaMañana_general= 1
        HsalidaMañana_general_  =


        HinicioTarde = 8:00
        HinicioTardeVigilante = 7:30


        HsalidaTarde_general=
        HsalidaTarde_general_  =

        tardanza :

        ROLES:

        DIAS DE TRABAJO:
        L, M , M, J , V ,S

        SABADO:
*/
