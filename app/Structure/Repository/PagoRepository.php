<?php
namespace App\Structure\Repository;

use App\Pago;
use Illuminate\Support\Facades\Auth;

class PagoRepository extends Pago
{
    public function ObtenerPagosPorCronograma($_cronogramaId)
    {
        return $this::where('MP_CRO_ID', $_cronogramaId)->get();
    }
    public function ObtenerNumeracionPorserie($serie)
    {
        return $this::where('MP_PAGO_SERIE', $serie)->max('MP_PAGO_NRO');
    }
    public function Crear($_pagoM)
    {
        $nuevoPago = new Pago();
        $nuevoPago = $_pagoM;
        $nuevoPago->save();
        return $nuevoPago->id();
    }
    public function BuscarPorId($_pagoId)
    {
        return $this::find($_pagoId);
    }
    public function ObtenerPagosPorOtrosConceptoPorMatricula($_matriculaId)
    {
       return $this::where('MP_MAT_ID',$_matriculaId)->where('MP_CONPAGO_ID','!=',null)->get();
    }
    public function ObtenerPagosPorFechaUsuarioActual($fecha)
    {
        return $this::whereDate('MP_PAGO_FECHA', '=',$fecha)->where('USU_ID',Auth::user()->id())->get();
    }
    public function ObtenerEntreFechas($_fechaInicial, $_fechaFinal)
    {
        return $this::where('MP_PAGO_FECHA','>=', $_fechaInicial)->where('MP_PAGO_FECHA','<=', $_fechaFinal)->orderBy('MP_PAGO_FECHA')->get();
    }
    public function ObtenerEntreFechasPorUsuario($_fechaInicial, $_fechaFinal, $_usuarioId)
    {
        return $this::where('MP_PAGO_FECHA','>=', $_fechaInicial)->where('MP_PAGO_FECHA','<=', $_fechaFinal)->where('USU_ID','<=', $_usuarioId)->orderBy('MP_PAGO_FECHA')->get();
    }
    public function ObtenerPorBancoYOperacion($_banco, $_numOperacion)
    {
        return $this::where('BANCO','=', $_banco)->where('NUMERO_OPERACION','=', $_numOperacion)->first();
    }
}
