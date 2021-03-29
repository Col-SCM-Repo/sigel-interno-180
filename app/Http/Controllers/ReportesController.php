<?php

namespace App\Http\Controllers;

use App\Pago;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function VerBoleta($pago_id)
    {
        $pago=Pago::find($pago_id);
        return view('reportes.pdf.boleta')->with('pago',$pago);
    }
}
