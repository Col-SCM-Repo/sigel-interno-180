<?php
namespace App\Structure\Services;

use App\Enums\JsonEnums;
use App\Mappers\AlumnoMapper;
use App\Structure\Repository\AlumnoRepository;

class AlumnoService
{
    private $_alumnoRepository ;
    private $_alumnoMapper ;
    public function __construct()
    {
        $this->_alumnoRepository =  new AlumnoRepository();
        $this->_alumnoMapper =  new AlumnoMapper();
    }
    public function BuscarPorNombresApellidosDNI($texto)
    {
        return $this->_alumnoMapper->ListModelToViewModel($this->_alumnoRepository->BuscarPorNombresApellidosDNI($texto));;
    }
    public function BuscarPorDNI($dni)
    {
        $_alumnoModel = $this->_alumnoRepository->BuscarPorDNI($dni);
        if(isset($_alumnoModel)){
            return $this->_alumnoMapper->ModelToViewModel($_alumnoModel);
        }else{
            return JsonEnums::NoEncontrado;
        }
    }
    public function BuscarPorId($alumno_id)
    {
        $_alumnoVM = $this->_alumnoMapper->ModelToViewModel( $this->_alumnoRepository->BuscarPorId($alumno_id));
        return $_alumnoVM;
    }
    public function CrearViewModel()
    {
        return $this->_alumnoMapper->ViewModel();
    }
    public function GuardarAlumno($alumnoVM)
    {
        $_alumnoModel = $this->_alumnoMapper->ViewModelToModel($alumnoVM);
        if ($alumnoVM->id!=0) {
            return $this->_alumnoRepository->Actualizar($_alumnoModel);
        }else{
            return $this->_alumnoRepository->Crear($_alumnoModel);
        }
    }
    public function GuardarImagen($imagen, $alumno_id)
    {
        $_alumnoVM=self::BuscarPorId($alumno_id);
        //Save image
        $fileExtencion = pathinfo($imagen->getClientOriginalName())['extension'];
        $fileName = $_alumnoVM->dni .'.'. $fileExtencion;
        $folder = 'images/alumno';
        $imagen->storeAs($folder,$fileName,'publicFile');
        return $_alumnoVM->id;
    }
    public function BuscarDeuda($_listaMatriculasVM)
    {
        $_pagoService =  new PagoService();
        $deuda =0;
        foreach ($_listaMatriculasVM as $matricula_VM) {
            foreach ($matricula_VM->cronogramas  as $cronograma) {
                if ($cronograma->estado!='CANCELADO'||$cronograma->estado!='EXONERADO') {
                    $cronograma->pagos = $_pagoService->ObtenerPagosPorCronograma($cronograma->id);
                    $saldo =$cronograma->monto;
                    foreach ($cronograma->pagos as $pago) {
                        $saldo -= $pago->monto;
                    }
                    $deuda += $saldo;
                }
            }
        }
        if ($deuda==0) {
            return false;
        } else {
            return $deuda;
        }
    }
}
