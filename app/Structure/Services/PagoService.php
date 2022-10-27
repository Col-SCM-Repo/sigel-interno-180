<?php
namespace App\Structure\Services;

use App\Enums\AlumnoMorosoEnum;
use App\Enums\TipoComprobanteEnum;
use App\Helpers\BancoPago;
use App\Helpers\CronogramaHelper;
use App\Helpers\TipoComprobante;
use App\Mappers\AlumnoMorosoMapper;
use App\Mappers\PagoEntreFechasMapper;
use App\Mappers\PagoMapper;
use App\Structure\Repository\PagoRepository;
use App\Structure\Repository\VacanteRepository;
use App\Vacante;
use Illuminate\Support\Facades\Auth;

class PagoService
{
    protected $_pagoMapper;
    protected $_pagoRespository;
    protected $_cronogramaService;
    protected $_conceptoPagoService;
    protected $_matriculaService;
    protected $_alumnoService;
    protected $_vacanteReposotory;
    protected $_alumnoMorosoMapper;
    protected $_pagoEntreFechasMapper;
    protected $_parentescoService;
    public function __construct()
    {
        $this->_pagoMapper= new PagoMapper();
        $this->_pagoRespository= new PagoRepository();
        $this->_cronogramaService= new CronogramaService();
        $this->_conceptoPagoService= new ConceptoPagoService();
        $this->_matriculaService= new MatriculaService();
        $this->_alumnoService= new AlumnoService();
        $this->_vacanteReposotory= new VacanteRepository();
        $this->_alumnoMorosoMapper= new AlumnoMorosoMapper();
        $this->_pagoEntreFechasMapper= new PagoEntreFechasMapper();
        $this->_parentescoService = new ParentescoService();
    }
    public function ObtenerPagosPorCronograma($cronogramaId)
    {
        $_listPagos = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorCronograma($cronogramaId));
        foreach ($_listPagos as $pagoVM) {
            $pagoVM->tipo_comprobante = TipoComprobante::Atexto($pagoVM->tipo_comprobante_id);
        }
        return $_listPagos;
    }
    public function CreaViewModel($cronograma_id)
    {
        $_pagoVM =  $this->_pagoMapper->ViewModel();
        if ($cronograma_id!=0) {
            $_cronogramaVm = $this->_cronogramaService->BuscarPorId($cronograma_id);
            $_pagoVM->saldo = $_cronogramaVm->monto_final;
            $_pagoVM->responsables_pago = $this->_parentescoService->BuscarPorAlumnoId( $_cronogramaVm->alumno_id );

            foreach ($_pagoVM->responsables_pago as $responsable_pago )
                if( $responsable_pago->responsable_defecto == true ){
                    $_pagoVM->responsable_pago_id = $responsable_pago->id;
                    break;
                }

            foreach (self::ObtenerPagosPorCronograma($cronograma_id) as $pago) {
                $_pagoVM->saldo -= $pago->monto;
            }
            $_pagoVM->monto = $_pagoVM->saldo;
        }
        $_pagoVM->fecha = date('Y-m-d');
        $_pagoVM->usuario_id = Auth::user()->id();
        $_pagoVM->serie_comprobante_id = Auth::user()->SerieComprobante()->get()->last()->id();
        $_pagoVM->serie = Auth::user()->SerieComprobante()->get()->last()->serie();
        return$_pagoVM;
    }
    public function GuardarPago($_pagoVM)
    {
        if($_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::BoletaElectronica || $_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::FaturaElectronica){
            $_pagoVM->numero = $this->_pagoRespository->ObtenerNumeracionPorserie($_pagoVM->serie)+1;
        }
       /*  else
            if($_pagoVM->tipo_comprobante_id==TipoComprobanteEnum::FaturaElectronica){
                $_pagoVM->numero = $this->_pagoRespository->ObtenerNumeracionPorserie($_pagoVM->serie)+1;
            } */


        if (isset($_pagoVM->cronograma_id)) {   // crear nota credito
           $cronogramaVM = $this->_cronogramaService->BuscarPorId($_pagoVM->cronograma_id);
           if(number_format($_pagoVM->monto,2)<number_format($_pagoVM->saldo,2)){
            $cronogramaVM->estado='SALDO';
            }else if(number_format($_pagoVM->monto,2)==number_format($_pagoVM->saldo,2)){
                $cronogramaVM->estado='CANCELADO';
            }
            $this->_cronogramaService->Actualizar($cronogramaVM);
        }
        $_pagoVM->banco = BancoPago::ObtenerBanco($_pagoVM->banco);
        return $this->_pagoRespository->Crear($this->_pagoMapper->ViewModelToModel($_pagoVM));
    }
    public function GuardarNotaCredito($_pagoVM,$pagoAnteriorId)
    {
        $_pagoAnteriorModel = $this->_pagoRespository->BuscarPorId($pagoAnteriorId);
        if (isset($_pagoAnteriorModel->CronogramaPago)) {
            $_montoPagado = 0;
            foreach (self::ObtenerPagosPorCronograma($_pagoAnteriorModel->CronogramaPago->id()) as $pago) {
                $_montoPagado += $pago->monto;
            }
            $_cronogramaVM = $this->_cronogramaService->BuscarPorId($_pagoAnteriorModel->CronogramaPago->id());
            if (number_format(number_format($_montoPagado,2)+number_format($_pagoVM->monto,2),2)==number_format(0,2)) {
                $_cronogramaVM->estado = 'PENDIENTE';
            } else if(number_format(number_format($_montoPagado,2)+number_format($_pagoVM->monto,2),2)<number_format($_cronogramaVM->monto_final,2)) {
                $_cronogramaVM->estado = 'SALDO';
            }
            $this->_cronogramaService->Actualizar($_cronogramaVM);
        }
        $_pagoVM->tipo_comprobante_id=TipoComprobanteEnum::NotaDeCredito;
        $_pagoVM->fecha_emision = date('Y-m-d\TH:i:s');
        $_pagoVM->banco = $_pagoAnteriorModel->BANCO;
        return $this->_pagoRespository->Crear($this->_pagoMapper->ViewModelToModel($_pagoVM));
    }
    public function ObtenerPagosPorOtrosConceptoPorMatricula($_matriculaId)
    {
        $_listPagosVM = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorOtrosConceptoPorMatricula($_matriculaId));
        foreach ($_listPagosVM as $pagoVM) {
            $pagoVM->concepto = $this->_conceptoPagoService->ObtenerPorId($pagoVM->concepto_pago_id);
            $pagoVM->tipo_comprobante = TipoComprobante::Atexto($pagoVM->tipo_comprobante_id);
        }
        return $_listPagosVM;
    }
    public function ObtenerPagosPorFechaUsuarioActual($_fecha)
    {
        $_listPagosVM = $this->_pagoMapper->ListModelToViewModel($this->_pagoRespository->ObtenerPagosPorFechaUsuarioActual($_fecha));
        foreach ($_listPagosVM as $pagoVM) {
            $_alumnoVM = $this->_alumnoService->BuscarPorId($this->_matriculaService->ObtenerPorId($pagoVM->matricula_id)->alumno_id);
            $pagoVM->nombres_alumno = $_alumnoVM->apellidos.', '. $_alumnoVM->nombres;
            $_conceptoPagoId = $pagoVM->cronograma_id? ($this->_cronogramaService->BuscarPorId($pagoVM->cronograma_id)->concepto_pago_id):($pagoVM->concepto_pago_id);
            $pagoVM->nombre_concepto = $this->_conceptoPagoService->ObtenerPorId($_conceptoPagoId)->concepto ;
        }
        return $_listPagosVM ;
    }
    public function ObtenerAlumnosMorosos($anio_id,$nivel_id,$seccion_id,$concepto_id, $estado)
    {
        $_listaAlumnoMorososVM = array();
        if ($seccion_id == AlumnoMorosoEnum::Todos) {
            $_seccionesM = $this->_vacanteReposotory->BuscarAulasPorAnioNivel($anio_id,$nivel_id);
            foreach ($_seccionesM as $_seccionM) {
                $_listaAux = self::AgregarAlumnosMorosos($_seccionM, $concepto_id, $estado);
                foreach ($_listaAux as $_alumnoMorosoVM) {
                    array_push($_listaAlumnoMorososVM, $_alumnoMorosoVM);
                }
            }
        } else {
            $_seccionM = $this->_vacanteReposotory->BuscarPorId($seccion_id);
            $_listaAlumnoMorososVM = self::AgregarAlumnosMorosos($_seccionM, $concepto_id, $estado);
        }
        return $_listaAlumnoMorososVM;
    }
    private function AgregarAlumnosMorosos(Vacante $_seccionM,$concepto_id, $estado )
    {
        $_listaAlumnoMorososVM = array();
        foreach ($_seccionM->Matriculas as $_matriculaM ) {
            foreach ($_matriculaM->CronogramaPagos as $_cronogramaM) {
                if ($estado == AlumnoMorosoEnum::Todos  ) {
                    if ($concepto_id==AlumnoMorosoEnum::Todos && ($_cronogramaM->estado()==AlumnoMorosoEnum::Saldo||$_cronogramaM->estado()==AlumnoMorosoEnum::Pendiente)) {
                        array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                    } else {
                        if ($_cronogramaM->ConceptoPago->id()==$concepto_id && ($_cronogramaM->estado()==AlumnoMorosoEnum::Saldo||$_cronogramaM->estado()==AlumnoMorosoEnum::Pendiente)) {
                            array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                        }
                    }
                } else {
                    if ($concepto_id==AlumnoMorosoEnum::Todos && $_cronogramaM->estado()==CronogramaHelper::EstadoTexto($estado)) {
                        array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                    } else {
                        if($_cronogramaM->ConceptoPago->id()==$concepto_id && $_cronogramaM->estado()==CronogramaHelper::EstadoTexto($estado)){
                            array_push($_listaAlumnoMorososVM, $this->_alumnoMorosoMapper->ModelsToViewModel($_matriculaM,$_seccionM,$_cronogramaM));
                        }
                    }
                }
            }
        }
        return $_listaAlumnoMorososVM;
    }
    public function ObtenerPagosEntreFechas($_fechaInicial, $_fechaFinal, $_usuarioId)
    {
        $_listaPagosVM = array();
        if ($_usuarioId==0) {
            $_pagosAux = $this->_pagoRespository->ObtenerEntreFechas($_fechaInicial, $_fechaFinal);
        } else {
            $_pagosAux = $this->_pagoRespository->ObtenerEntreFechasPorUsuario($_fechaInicial, $_fechaFinal, $_usuarioId);
        }
        foreach ($_pagosAux as $_pagoM ) {
            array_push($_listaPagosVM, $this->_pagoEntreFechasMapper->ModelToViewModel($_pagoM));
        }
        return $_listaPagosVM;
    }
    public function ValidarPago($_pagoVM)
    {
        $_pagoVM->banco = BancoPago::ObtenerBanco($_pagoVM->banco);
        $pagoExiste = $this->_pagoRespository->ObtenerPorBancoYOperacion($_pagoVM->banco, $_pagoVM->numero_operacion);
        if(isset($pagoExiste)){
            return $pagoExiste;
        }else{
            return null;
        }
    }
}
