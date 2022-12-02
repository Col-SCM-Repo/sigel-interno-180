<?php

namespace App\Http\Controllers;

use App\Structure\Services\DocumentosService;
use App\Structure\Services\ModuloSistemaService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DocumentosController extends Controller
{
    protected $_moduloSistemService;
    protected $_documentoService;

    public function __construct()
    {
        $this->_moduloSistemService = new ModuloSistemaService();
        $this->_documentoService = new DocumentosService();
    }

    public function index($modulo = ''){
        $moduloSistema_VM = $this->_moduloSistemService->BuscarModuloPorNombre($modulo);
        $modulo_id = '';
        $modulosDisponibles_VM = [];

        if($moduloSistema_VM)   $modulo_id = $moduloSistema_VM->id;
        else    $modulosDisponibles_VM = $this->_moduloSistemService->ObtenerTodosModulos();

        return view('modulos.logistica.documentos', compact( 'modulo', 'modulo_id', 'modulosDisponibles_VM'));
    }

    public function informacionDocumentos(){
        $data = [
            'Pagos y matriculas' => [
                'alumno' => [
                    'alu_ape' => 'Apellidos del alumno',
                    'alu_nom' => 'Nombres del alumno',
                    'alu_nom_complt' => 'Nombres completos del alumno (apellidos + nombres)',
                    'alu_cel' => 'Celular del alumno',
                    'alu_tel' => 'Telefono del alumno',
                    'alu_dir' => 'Dirección del alumno',
                    'alu_f_nacimiento' => 'Fecha de nacimiento del alumno',
                    'alu_dni' => 'Documento de identidad del alumno (DNI)',
                    'alu_foto_url' => 'URL Foto del alumno en el servidor',
                ],
                'padre' => [
                    'padre_ape' => 'Apellidos del padre.',
                    'padre_nom' => 'Nombres del padre.',
                    'padre_nom_complt' => 'Nombres completos del padre (apellidos + nombre).',
                    'padre_dir' => 'Dirección del padre.',
                    'padre_dni' => 'Documento de identidad del padre (DNI).',
                    'padre_cntr_laboral' => 'Centro laboral del padre.',
                    'padre_ocupa' => 'Ocupación del padre.',
                    'padre_cel' => 'Celular del padre.',
                    'padre_tel' => 'Telefono del padre.',
                ],
                'madre' => [
                    'madre_ape' => 'Apellidos de la madre.',
                    'madre_nom' => 'Nombres de la madre.',
                    'madre_nom_complt' => 'Nombres completos de la madre (apellidos + nombre).',
                    'madre_dir' => 'Dirección de la madre.',
                    'madre_dni' => 'Documento de identidad de la madre (DNI).',
                    'madre_cntr_laboral' => 'Centro laboral de la madre.',
                    'madre_ocupa' => 'Ocupación de la madre.',
                    'madre_cel' => 'Celular de la madre.',
                    'madre_tel' => 'Telefono de la madre.',
                ],
                'responsable' => [
                    'resp_ape' => 'Apellidos del responsable.',
                    'resp_nom' => 'Nombres del responsable.',
                    'resp_nom_complt' => 'Nombres completos del responsable (apellidos + nombre).',
                    'resp_dir' => 'Dirección del responsable.',
                    'resp_dni' => 'Documento de identidad del responsable (DNI).',
                    'resp_cntr_laboral' => 'Centro laboral del responsable.',
                    'resp_genero' => 'Ocupación del responsable.',
                    'resp_ocupa' => 'Ocupación del responsable.',
                    'resp_cel' => 'Celular del responsable.',
                    'resp_tel' => 'Telefono del responsable.',
                ],
                'matricula' => [
                    /* 'mat_id' => '',
                    'mat_vacante_id' => '', */
                    'mat_f_ingreso' => 'Fecha de ingreso.',
                    'mat_f_matricula' => 'Fecha de matricula.',
                    'mat_nivel' => 'Nivel de la vacante.',
                    'mat_grado' => 'Grado de la vacante.',
                    'mat_seccion' => 'Sección de la vacante.',
                    'mat_anio_nom' => 'Nombre del año escolar.',
                    'mat_anio_est' => 'Estado del año escolar.',
                    'mat_anio_desc' => 'Descripcion del año escolar.',
                    'mat_anio_f_inicio' => 'Fecha inicio del año escolar.',
                    'mat_anio_f_fin' => 'Fecha fin del año escolar.',
                    'mat_sit' => 'Situación de la matricula.',
                    'mat_ie_procedencia' => 'Institución educativa de procedencia.',
                ]
            ],
        ];
        /* return $data; */
        return view('modulos.logistica.documentos-informacion', compact('data'));
    }

    public function obtenerDocumentosFiltro( $modulo_id = 0 ){
        return response()->json( $this->_documentoService->BuscarPorModuloSistemaId($modulo_id) );
    }

    public function obtenerViewModel (){

        return response()->json($this->_documentoService->ViewModel());
    }

    public function guardarDocumento(Request $request){
        $moduloSistema = $this->_moduloSistemService->BuscarModuloPorId($request->modulo_sistema_id);
        if(!$moduloSistema) throw new Exception('No se encontro el modulo ');

        $archivo = $request->file('archivo');
        $fileExtencion = pathinfo($archivo->getClientOriginalName())['extension'];
        $fileName = $request->nombre_archivo.'-'.time().'.'.$fileExtencion;
        $folder = 'documentos/'.$moduloSistema->nombre_modulo;
        $archivo->storeAs($folder,$fileName,'publicFile');

        $documento_VM = (object)$request;
        $documento_VM->nombre_archivo =$fileName;
        $documento_VM->directorio = $folder;
        return $this->_documentoService->Guardar($documento_VM);
    }

    public function eliminarDocumento ( $documento_id ) {
        return response()->json( $this->_documentoService->eliminar($documento_id) );
    }


}
