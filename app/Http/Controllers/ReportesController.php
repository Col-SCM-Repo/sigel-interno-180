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
        $pdf = PDF::loadView('reportes.pdf.boleta', ['pago'=>$pago] );
        return $pdf->stream('invoice.pdf');
    }
}
