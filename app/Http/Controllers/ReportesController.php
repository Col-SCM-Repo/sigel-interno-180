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
}
