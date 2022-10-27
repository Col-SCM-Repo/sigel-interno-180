<?php

namespace App\Http\Controllers;

use App\Descuento;
use Exception;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function getDescuentos(){
        return Descuento::all();
    }

    public function getDescuento( $descuento_id ){
        return Descuento::find($descuento_id);
    }

    public function registrarDescuento ( Request $request) {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|in:porcentaje,monto',
            'valor' => 'required|numeric',
        ]);

        $descuento = new Descuento();
        $descuento->MP_NOMBRE = $request->nombre;
        $descuento->DESCRIPCION = $request->descripcion;
        $descuento->MP_TIPO_BECA = $request->tipo;
        $descuento->VALOR = $request->valor;
        $descuento->save();
        return $descuento->MP_DESCUENTO_ID;
    }

    public function actualizarDescuento ( Request $request, $descuento_id){
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'tipo' => 'required|string|in:porcentaje,monto',
            'valor' => 'required|numeric',
        ]);

        $descuento = Descuento::find($descuento_id);
        if(!$descuento) throw new Exception('Error, no se encontro el descuento');

        $descuento->MP_NOMBRE = $request->nombre;
        $descuento->DESCRIPCION = $request->descripcion;
        $descuento->MP_TIPO_BECA = $request->tipo;
        $descuento->VALOR = $request->valor;
        $descuento->save();
        return $descuento->MP_DESCUENTO_ID;
    }

    public function eliminarDescuento ( $descuento_id ){
        $descuento = Descuento::find($descuento_id);
        $descuento->delete();
        return $descuento->MP_DESCUENTO_ID;
    }

}
