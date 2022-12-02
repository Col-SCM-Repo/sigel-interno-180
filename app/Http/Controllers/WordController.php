<?php

namespace App\Http\Controllers;

use App\Enums\TipoParentescoEnum;
use App\Structure\Services\AlumnoService;
use App\Structure\Services\DocumentosService;
use App\Structure\Services\MatriculaService;
use App\Structure\Services\ParentescoService;
use App\Structure\Services\VacanteService;
use App\TipoParentesco;
use DateTime;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class WordController extends Controller
{
    private $_matriculaService,
            $_alumnoService,
            $_documentoService,
            $_parentescoService,
            $_vacanteService;

    public function __construct()
    {
        $this->_matriculaService = new MatriculaService();
        $this->_documentoService = new DocumentosService();
        $this->_alumnoService = new AlumnoService();
        $this->_parentescoService = new ParentescoService();
        $this->_vacanteService = new VacanteService();
    }

    public function index(){
        try {
            $plantilla = new TemplateProcessor('documentos/CONTRATO2022.docx');
            $plantilla->setValue('nombre', 'JUAN');
            $plantilla->setValue('apellidos', 'PEREZ BEJAR');
            $plantilla->setValue('dni', '66666666');

            $archivoTemporal = tempnam( sys_get_temp_dir(), 'PHPWord' );
            $plantilla->saveAs($archivoTemporal);

            /*
                Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
                Settings::setPdfRendererPath('.');

                dd($archivoTemporal);


                $archivoTemporalPDF = tempnam( sys_get_temp_dir(), 'PHPWord' );

                $phpWord = IOFactory::load($archivoTemporal);
                $phpWord->save($archivoTemporal, 'PDF');
                dd($archivoTemporalPDF);
                $xmlWriter = IOFactory::: createWriter($plantilla, "Word2007");
                $xmlWriter->save("php://output");

                $phpWord = IOFactory::load(, 'Word2007');
                $phpWord->save('document.pdf', 'PDF');
            */

            $headers = [
                "Content-Type: application/octet-stream",
            ];

            return response()->download( $archivoTemporal , 'un_doc_muy_complicado.pdf', $headers )->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back($e->getCode());
        }


    }

    public function generarDocumentosMatricula ( Request $request ){
        $request->validate([
            'matricula_id' => 'required | integer | min:0',
            'documento_id' => 'required | integer | min:0',
           /*  'directorio_documento' => 'required|string',
            'nombre_documento' => 'required|string|min:1', */
        ]);

        $_matriculaVM = $this->_matriculaService->ObtenerPorId($request->matricula_id);
        $_documentoVM = $this->_documentoService->BuscarDocumentoPorId($request->documento_id);

        if(!$_matriculaVM || !$_documentoVM) throw new Exception('Error, codigos id no validos.');
        $_alumnoVM = $this->_alumnoService->BuscarPorId( $_matriculaVM->alumno_id );
        $_padreVM = $this->_parentescoService->BuscarPorAlumnoIdYParentesco($_matriculaVM->alumno_id, TipoParentescoEnum::PADRE);
        $_madreVM = $this->_parentescoService->BuscarPorAlumnoIdYParentesco($_matriculaVM->alumno_id, TipoParentescoEnum::MADRE);
        $_responsableVM = $this->_parentescoService->BuscarResponsableMatricula($_matriculaVM->alumno_id);

        $_vacanteVM = $this->_vacanteService->BuscarPorId($_matriculaVM->vacante_id);

        $plantilla = new TemplateProcessor($_documentoVM->directorio.'/'.$_documentoVM->nombre_archivo);

        date_default_timezone_set("America/Lima");
        setlocale(LC_TIME, 'es_PE.UTF-8','esp');

        $clavesDocumento  = [
            'alu_id' => $_alumnoVM->id,
            'alu_ape' => strtoupper($_alumnoVM->apellidos),
            'alu_nom' => strtoupper($_alumnoVM->nombres),
            'alu_nom_complt' => strtoupper($_alumnoVM->apellidos.', '.$_alumnoVM->nombres),
            'alu_cel' => $_alumnoVM->celular,
            'alu_tel' => $_alumnoVM->telefono,
            'alu_dir' => strtoupper($_alumnoVM->direccion),
            'alu_f_nacimiento' => $_alumnoVM->fecha_nacimiento,
            'alu_dni' => $_alumnoVM->dni,
            'alu_foto_url' => $_alumnoVM->url_foto,

            'padre_id' => $_padreVM->id,
            'padre_ape' => strtoupper($_padreVM->apellidos),
            'padre_nom' => strtoupper($_padreVM->nombres),
            'padre_nom_complt' =>  strtoupper($_padreVM->apellidos.', '.$_padreVM->nombres),
            'padre_dir' => strtoupper($_padreVM->direccion),
            'padre_dni' => $_padreVM->dni,
            'padre_cntr_laboral' => strtoupper($_padreVM->centro_laboral), //
            'padre_genero' => strtoupper($_padreVM->genero),
            'padre_ocupa' => strtoupper($_padreVM->ocupacion),  //
            'padre_cel' => $_padreVM->celular,
            'padre_tel' => $_padreVM->telefono,

            'madre_id' => $_madreVM->id,
            'madre_ape' => strtoupper($_madreVM->apellidos),
            'madre_nom' => strtoupper($_madreVM->nombres),
            'madre_nom_complt' =>  strtoupper($_madreVM->apellidos.', '.$_madreVM->nombres),
            'madre_dir' => strtoupper($_madreVM->direccion),
            'madre_dni' => $_madreVM->dni,
            'madre_cntr_laboral' => strtoupper($_madreVM->centro_laboral), //
            'madre_genero' => strtoupper($_madreVM->genero),
            'madre_ocupa' => strtoupper($_madreVM->ocupacion),  //
            'madre_cel' => $_madreVM->celular,
            'madre_tel' => $_madreVM->telefono,

            'resp_id' => $_responsableVM->id,
            'resp_ape' => strtoupper($_responsableVM->apellidos),
            'resp_nom' => strtoupper($_responsableVM->nombres),
            'resp_nom_complt' =>  strtoupper($_responsableVM->apellidos.', '.$_responsableVM->nombres),
            'resp_dir' => strtoupper($_responsableVM->direccion),
            'resp_dni' => $_responsableVM->dni,
            'resp_cntr_laboral' => strtoupper($_responsableVM->centro_laboral), //
            'resp_genero' => strtoupper($_responsableVM->genero),
            'resp_ocupa' => strtoupper($_responsableVM->ocupacion),  //
            'resp_cel' => $_responsableVM->celular,
            'resp_tel' => $_responsableVM->telefono,

            'mat_id' => $_matriculaVM->id,
            'mat_vacante_id' => $_matriculaVM->vacante_id,
            'mat_f_ingreso' => $_matriculaVM->fecha_ingreso,
            'mat_f_matricula' =>  strftime( '%A, %d de %B de %Y', strtotime($_matriculaVM->fecha_matricula)) ,
            'mat_nivel' => strtoupper($_vacanteVM->nivel->nivel),
            'mat_grado' => strtoupper($_vacanteVM->grado->grado),
            'mat_seccion' => strtoupper($_vacanteVM->seccion->seccion),
            'mat_anio_nom' => strtoupper($_vacanteVM->anio->nombre),
            'mat_anio_est' => strtoupper($_vacanteVM->anio->estado),
            'mat_anio_desc' => strtoupper($_vacanteVM->anio->descripcion),
            'mat_anio_f_inicio' => $_vacanteVM->anio->fecha_inicio,
            'mat_anio_f_fin' => $_vacanteVM->anio->fecha_fin,
            'mat_sit' => strtoupper($_matriculaVM->situacion),
            'mat_ie_procedencia' => strtoupper($_matriculaVM->institucion_educativa_procedencia),   //institucion_educativa_procedencia_id
        ];
        $plantilla->setValues($clavesDocumento);

        $archivoTemporal = tempnam( sys_get_temp_dir(), 'PHPWord' );
        $plantilla->saveAs($archivoTemporal);

        $headers = [ "Content-Type: application/octet-stream", ];

        return response()->download( $archivoTemporal , 'un_doc_muy_complicado.pdf', $headers )->deleteFileAfterSend(true);
    }

}
