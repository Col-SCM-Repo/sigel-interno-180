<?php
namespace App\Structure\Services;

use App\Mappers\CronogramaMapper;
use App\Mappers\MatriculaMapper;
use App\Structure\Repository\CronogramaRepository;
use App\Structure\Repository\MatriculaRepository;

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
    }
    public function ObtenerMatriculasPorAlumno($alumno_id)
    {
        $_listMatriculasVM = $this->_matriculaMapper->ListModelToViewModel($this->_matriculaRepository->ObtenerMatriculasPorAlumno($alumno_id));
        foreach ($_listMatriculasVM as $matriculaVM) {
            $matriculaVM->vacante =  $this->_vacanteService->BuscarPorId($matriculaVM->vacante_id);
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
        if ($matriculaVM->id!=0) {
            $matricula_id = $this->_matriculaRepository->Actualizar($_matriculaModel);
            if($matriculaVM->monto_matricula!=''||$matriculaVM->monto_pension!=''){
                foreach ($_matriculaModel->CronogramaPagos as $cronograma) {
                    $cronograma->MP_CRO_MONTO = $cronograma->ConceptoPago->concepto_id()==1? ($matriculaVM->monto_matricula!=''?$matriculaVM->monto_matricula:$cronograma->monto()):($matriculaVM->monto_pension!=''?$matriculaVM->monto_pension:$cronograma->monto());
                    $this->_cronogramaService->Actualizar($this->_cronogramaMapper->ModelToViewModel($cronograma));
                }
            }
            return $matricula_id;
        }else{
            $matricula_id = $this->_matriculaRepository->Crear($_matriculaModel);
            $pensiones = $this->_conceptoPagoService->ObtenerPensionesAnioActualYNivel($matriculaVM->nivel);
            foreach ($pensiones as $pension) {
                $nuevoCronogramaVM = $this->_cronogramaService->CrearViewModel();
                $nuevoCronogramaVM->id =$this->_cronogramaRepository->ObtenerUltimoId();
                $nuevoCronogramaVM->matricula_id =$matricula_id;
                $nuevoCronogramaVM->concepto_pago_id =$pension->id;
                $nuevoCronogramaVM->fecha_vencimiento = date('Y-m-d\TH:i:s',strtotime($pension->fecha_vencimiento));
                $nuevoCronogramaVM->tipo_deuda =$pension->id==1? 'DERECHO DE PAGO':'PENSION';
                $nuevoCronogramaVM->monto =$pension->id==1? ($matriculaVM->monto_matricula!=''?$matriculaVM->monto_matricula:($pension->monto)):($matriculaVM->monto_pension!=''?$matriculaVM->monto_pension:($matriculaVM->tipo_matricula_id==3?($pension->monto/2):$pension->monto));
                $nuevoCronogramaVM->estado =$pension->id==1?('PENDIENTE'):($matriculaVM->tipo_matricula_id==2?('EXONERADO'):('PENDIENTE'));
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
}
