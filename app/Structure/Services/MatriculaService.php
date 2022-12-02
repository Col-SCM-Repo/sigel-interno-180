<?php
namespace App\Structure\Services;

use App\CronogramaPago;
use App\Descuento;
use App\Enums\EstadoMatriculaEnum;
use App\Enums\ParteCarnetEnum;
use App\Helpers\EstadoMatricula;
use App\Mappers\CronogramaMapper;
use App\Mappers\MatriculaMapper;
use App\Matricula;
use App\Structure\Repository\CronogramaRepository;
use App\Structure\Repository\MatriculaRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MatriculaService
{
    protected $_matriculaMapper;
    protected $_matriculaRepository;
    protected $_vacanteService;
    protected $_alumnoService;
    protected $_cronogramaService;
    protected $_cronogramaMapper;
    protected $_conceptoPagoService;
    protected $_cronogramaRepository;
    protected $_parentescoService;
    public function __construct()
    {
       $this->_matriculaMapper = new MatriculaMapper();
       $this->_matriculaRepository = new MatriculaRepository();
       $this->_vacanteService = new VacanteService();
       $this->_alumnoService = new AlumnoService();
       $this->_cronogramaService = new CronogramaService();
       $this->_cronogramaMapper = new CronogramaMapper();
       $this->_cronogramaRepository = new CronogramaRepository();
       $this->_conceptoPagoService = new ConceptoPagoService();
       $this->_parentescoService = new ParentescoService();
    }
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        $_listMatriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorAlumno($alumno_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
            $matriculaVM->estado = EstadoMatricula::ALetras($matriculaVM->estado);
        }
        return $_listMatriculasVM;
    }
    public function ObtenerMatriculasPorVacanteId($vacante_id)
    {
        $_listMatriculasVM= $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorVacanteId($vacante_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
            $matriculaVM->alumno =  $this->_alumnoService->BuscarPorId($matriculaVM->alumno_id);
        }
        return $_listMatriculasVM;
    }
    public function ObtenerPorId($matricula_id)
    {
        return $this->_matriculaMapper->ModelToViewModel($this->_matriculaRepository->ObtenerPorId($matricula_id));
    }
    public function CrearViewModel()
    {
        return $this->_matriculaMapper->ViewModel();
    }
    public function Guardar($matriculaVM)
    {
        $_matriculaModel = $this->_matriculaMapper->ViewModelToModel($matriculaVM);
        if ($matriculaVM->id!=0) {//la matricula existe y se actualiza el cronograma
            $matricula_id = $this->_matriculaRepository->Actualizar($_matriculaModel);
            if ($matriculaVM->estado==EstadoMatriculaEnum::Retirado) {
                self::RetirarAlumno($matriculaVM);
            }else{
                if($matriculaVM->monto_matricula!=''||$matriculaVM->monto_pension!=''){     // REVISARRRRRRRRRR
                    foreach ($_matriculaModel->CronogramaPagos as $cronograma) {
                        $monto_cronograma = $cronograma->ConceptoPago->concepto_id()==1? ($matriculaVM->monto_matricula!=''?$matriculaVM->monto_matricula:$cronograma->monto()):($matriculaVM->monto_pension!=''?$matriculaVM->monto_pension:$cronograma->monto());
                        $cronograma->MP_CRO_MONTO = $monto_cronograma;
                        $cronograma->MONTO_COBRAR = $monto_cronograma;
                        $this->_cronogramaService->Actualizar($this->_cronogramaMapper->ModelToViewModel($cronograma));
                    }
                }
            }
            return $matricula_id;
        }else{//la matricula no existe y se crea junto a su cronograma
            $matricula_id = $this->_matriculaRepository->Crear($_matriculaModel);

            $pensiones = $this->_conceptoPagoService->ObtenerPensionesAnioActualYNivel($matriculaVM->nivel);
            foreach ($pensiones as $pension) {
                $nuevoCronogramaVM = $this->_cronogramaService->CrearViewModel();
                $nuevoCronogramaVM->id =$this->_cronogramaRepository->ObtenerUltimoId();
                $nuevoCronogramaVM->matricula_id =$matricula_id;
                $nuevoCronogramaVM->concepto_pago_id =$pension->id;
                $nuevoCronogramaVM->fecha_vencimiento = date('Y-m-d\TH:i:s',strtotime($pension->fecha_vencimiento));
                $nuevoCronogramaVM->tipo_deuda =$pension->id==1? 'DERECHO DE PAGO':'PENSION';

                $monto_cronograma = $pension->id==1? ($matriculaVM->monto_matricula!=''?$matriculaVM->monto_matricula:($pension->monto)):(date('m',strtotime($pension->fecha_vencimiento))<date('m',strtotime($matriculaVM->fecha_ingreso))? '0.0':($matriculaVM->monto_pension!=''?$matriculaVM->monto_pension:($matriculaVM->tipo_matricula_id==3?($pension->monto/2):$pension->monto)));
                $nuevoCronogramaVM->monto_inicial = $monto_cronograma ;
                $nuevoCronogramaVM->monto_descuento = 0 ;
                $nuevoCronogramaVM->monto_cobrar = $monto_cronograma ;
                $nuevoCronogramaVM->estado =$pension->id==1?('PENDIENTE'):(($matriculaVM->tipo_matricula_id==2||date('m',strtotime($pension->fecha_vencimiento))<date('m',strtotime($matriculaVM->fecha_ingreso)))?('EXONERADO'):('PENDIENTE'));
                $aux_max = $nuevoCronogramaVM->id;
                while ($nuevoCronogramaVM->id==$aux_max) {
                    $aux_max = $this->_cronogramaRepository->ObtenerUltimoId();;
                    $nuevoCronogramaVM->id++;
                    if ($nuevoCronogramaVM->id!=$aux_max) {
                        $this->_cronogramaService->Crear($nuevoCronogramaVM);
                    }
                }
            }

            return $matricula_id;
        }
    }
    public function ObtenerMatriculasPorAula($aula_id)
    {
        $matriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->BuscarPorVacanteId($aula_id));
        foreach ($matriculasVM as $matriculaVM) {
            $alumnoVM = $this->_alumnoService->BuscarPorId($matriculaVM->alumno_id);
            $matriculaVM->nombres_alumno = $alumnoVM->apellidos .', '. $alumnoVM->nombres;
            $matriculaVM->alumno = $alumnoVM;
            $matriculaVM->pariente = $this->_parentescoService->BuscarPorID($matriculaVM->pariente_id);
        }
        return $matriculasVM;
    }

    public function ObtenerDatosCarnet($matricula_id)
    {
        $_matriculaVM = self::ObtenerPorId($matricula_id);
        $_matriculaVM->alumno = $this->_alumnoService->BuscarPorId($_matriculaVM->alumno_id);
        $_matriculaVM->vacante = $this->_vacanteService->BuscarPorId($_matriculaVM->vacante_id);
        $_matriculaVM->frente_carnet = ParteCarnetEnum::Frente;
        $_matriculaVM->reverso_carnet = ParteCarnetEnum::Reverso;
        return$_matriculaVM;
    }
    public function ObtenerDatosCarnetPorVacante($vacante_id)
    {
        $_listMatriculasVM = self::ObtenerMatriculasPorVacanteId($vacante_id);
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->frente_carnet = ParteCarnetEnum::Frente;
            $matriculaVM->reverso_carnet = ParteCarnetEnum::Reverso;
        }
        return $_listMatriculasVM;
    }
    public function ObtenerMatriculasConCronogramaPorAlumno($alumno_id)
    {
        $_listMatriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorAlumno($alumno_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->estado = EstadoMatricula::ALetras($matriculaVM->estado);
            $matriculaVM->cronogramas= $this->_cronogramaService->ObtenerCronogramasPorMatriculaId($matriculaVM->id);
        }
        return $_listMatriculasVM;
    }
    public function RetirarAlumno($matriculaVM)
    {
        $_matriculaModel = $this->_matriculaMapper->ViewModelToModel($matriculaVM);
        foreach ($_matriculaModel->CronogramaPagos as $cronograma) {
            if (date('m',strtotime($cronograma->MP_CRO_FECHAVEN))>date('m')) {
                $cronograma->MP_CRO_MONTO = 0;
                $cronograma->MONTO_FINAL = 0;
                $cronograma->MONTO_DESCUENTO = null;
                $cronograma->MP_CRO_ESTADO = 'EXONERADO';
                $this->_cronogramaService->Actualizar($this->_cronogramaMapper->ModelToViewModel($cronograma));
            }
        }
    }
    public function AplicarDescuentoBecar( $matricula_id, $descuento_id, $cronogramas_afectados ){
        $descuento =    null;
        $matricula =    null;

        if($descuento_id>0) $descuento = Descuento::find($descuento_id);
        $matricula = Matricula::find($matricula_id);
        if(!$matricula) throw new NotFoundResourceException("Error, no se encontro a la matricula con codido $matricula_id .");

        if($descuento){ // Aplica descuento
            $matricula->MP_DESCUENTO_ID = $descuento->Id();
            foreach ($cronogramas_afectados as $cronograma_id) {
                $cronograma = CronogramaPago::find($cronograma_id);

                if($cronograma){
                    $cronograma->MONTO_DESCUENTO = $descuento->calcularDescuento( $cronograma->MP_CRO_MONTO );
                    $cronograma->MONTO_COBRAR = $cronograma->MP_CRO_MONTO - $cronograma->MONTO_DESCUENTO;
                    // se actualiza el monto y ya no hay devoluciones
                    if($cronograma->MONTO_COBRAR <= 0 ){
                        $cronograma->MONTO_COBRAR = 0;
                        $cronograma->MP_CRO_ESTADO = 'EXONERADO';
                    }
                    $cronograma->save();
                }
            }
        }
        else{ // Quita descuento
            $matricula->MP_DESCUENTO_ID = null;
            $cronogramasMatricula = CronogramaPago::where('MP_MAT_ID', $matricula_id)
                                                    ->where('MP_CRO_ESTADO', '!=', 'CANCELADO')
                                                    ->where('MONTO_DESCUENTO', '>', 0)
                                                    ->get();
            foreach ($cronogramasMatricula  as $cronograma) {
                $cronograma->MONTO_DESCUENTO = null ;
                $cronograma->MONTO_COBRAR = $cronograma->MP_CRO_MONTO ;
                $cronograma->save();
            }
        }
        $matricula->save();
        return true;
    }

    public function ultimaMatricula( $alumno_id ){
        $matriculaM = $this->_matriculaRepository->UltimaMatricula($alumno_id);
        return $matriculaM ? $this->_matriculaMapper->ModelToViewModel( $matriculaM ) : null;
    }
}
