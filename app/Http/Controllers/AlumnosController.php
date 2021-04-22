<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Helpers\OrdenarArray;
use App\Matricula;
use App\Structure\Services\AlumnoService;
use App\Structure\Services\CentroLaboralService;
use App\Structure\Services\DistritoService;
use App\Structure\Services\GradoInstruccionService;
use App\Structure\Services\OcupacionService;
use App\Structure\Services\PaisService;
use App\Structure\Services\ParentescoService;
use App\Structure\Services\ReligionService;
use App\Structure\Services\TipoDocumentoService;
use App\Structure\Services\TipoParentescoService;
use Illuminate\Http\Request;

class AlumnosController extends Controller
{
    protected $ordenarArray;
    protected $_alumnoService;
    protected $_parentescoService;
    protected $_paisService;
    protected $_distritoService;
    protected $_religionService;
    protected $_tipoDocumentoService;
    protected $_tipoParentescoService;
    protected $_gradoInstruccionService;
    protected $_centroLaboralService;
    protected $_ocupacionService;
    public function __construct(OrdenarArray $ordenarArray,
                            AlumnoService $_alumnoService,
                            ParentescoService $_parentescoService,
                            PaisService $_paisService,
                            DistritoService $_distritoService,
                            ReligionService $_religionService,
                            TipoDocumentoService $_tipoDocumentoService,
                            TipoParentescoService $_tipoParentescoService,
                            GradoInstruccionService $_gradoInstruccionService,
                            CentroLaboralService $_centroLaboralService,
                            OcupacionService $_ocupacionService)
    {
        $this->ordenarArray=$ordenarArray;
        $this->_alumnoService=$_alumnoService;
        $this->_parentescoService=$_parentescoService;
        $this->_paisService=$_paisService;
        $this->_distritoService=$_distritoService;
        $this->_religionService=$_religionService;
        $this->_tipoDocumentoService=$_tipoDocumentoService;
        $this->_tipoParentescoService=$_tipoParentescoService;
        $this->_gradoInstruccionService=$_gradoInstruccionService;
        $this->_centroLaboralService=$_centroLaboralService;
        $this->_ocupacionService=$_ocupacionService;
    }
    public function Index()
    {
        return view('alumnos.index');
    }
    public function ObtenerAlumnos(Request $request)
    {
        $texto = mb_strtoupper($request->cadena);
        return response()->json($this->_alumnoService->BuscarPorNombresApellidosDNI($texto));
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
    public function ObtenerDatos(Request $request)
    {
        if ($request->alumno_id!=0) {
            $alumno = $this->_alumnoService->BuscarPorId($request->alumno_id);
            //Obtenemos los apoderados(familiares) del Alumno
            $alumno->apoderados = $this->_parentescoService->BuscarPorAlumnoId($alumno->id);
        } else {
            $alumno = $this->_alumnoService->CrearViewModel();
        }
        $data = [
            'alumno' => $alumno,
            'paises'=>$this->_paisService->ObtenerPaises(),
            'distritos'=>$this->_distritoService->ObtenerDistritos(),
            'religiones'=>$this->_religionService->ObtenerReligiones(),
            'tipo_documentos'=>$this->_tipoDocumentoService->ObtenerTiposDocumento(),
            'tipo_parentescos'=>$this->_tipoParentescoService->ObtenerTiposParentesco(),
            'grados_intruccion'=>$this->_gradoInstruccionService->ObtenerGradosInstruccion(),
            'centro_laborales'=>$this->_centroLaboralService->ObtenerCentrosLaboral(),
            'ocupaciones'=>$this->_ocupacionService->ObtenerOcupaciones()
        ];
        return response()->json($data);
    }
    public function Guardar(Request $request)
    {
        return $this->_alumnoService->GuardarAlumno((object)$request->alumno);
    }
    public function ObtenerAlumnoPorDNI(Request $request)
    {
        return response()->json($this->_alumnoService->BuscarPorDNI($request->alumno_dni));
    }
    //morosos
    public function VistaMorosos()
    {
        return view('alumnos.morosos');
    }
}
