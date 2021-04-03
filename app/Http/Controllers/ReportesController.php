<?php

namespace App\Http\Controllers;

use App\Pago;
use Illuminate\Http\Request;
use PDF;
class ReportesController extends Controller
{
    public function VerBoleta($pago_id)
    {
        $pago=Pago::find($pago_id);
        $pdf = PDF::loadView('reportes.pdf.boleta', ['pago'=>$pago] )->setPaper( [0, 0, 220, 320]);
        return $pdf->stream('invoice.pdf');
    }
    public function DescargarListaAlumnos(Request $request)
    {
        return view('reportes.excel.aulas_con_alumnos')->with('alumnos',$request->alumnos)->with('seccion', $request->seccion)->with('anio', $request->anio);
    }
    public function DescargarPagosDelDia(Request $request)
    {
        $pdf = PDF::loadView('reportes.pdf.pagos_del_dia', ['pagos'=>$request->pagos, 'fecha'=>$request->fecha] );
        return $pdf->download('invoice.pdf');
    }
}
