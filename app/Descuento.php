<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    public  $table = 'MP_DESCUENTOS';
    public  $primaryKey = 'MP_DESCUENTO_ID';
    public  $timestamps = false;

    public function Id(){
        return $this->MP_DESCUENTO_ID;
    }


    public function calcularDescuento ( $monto ){
        switch ($this->MP_TIPO_BECA) {
            case 'porcentaje':
                return round($monto, 3) * $this->VALOR /100;
            case 'monto':
                return $this->VALOR;
            default: return null;
        }

    }


}
