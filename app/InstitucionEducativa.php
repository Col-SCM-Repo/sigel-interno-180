<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitucionEducativa extends Model
{
    protected $table = 'MP_IEPROCEDENCIA';
    protected $primaryKey = 'MP_IEPRO_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_IEPRO_ID',
        'MP_IEPRO_NOMBRE',
        'MP_IEPRO_REFERENCIA',
        'MP_IEPRO_CODMODULAR',
        'MP_IEPRO_DIRECCION',
        'MP_TIPOIEPRO_ID',
        'MP_IECON_ID',
        'MP_UBIG_ID',
        'MP_PAIS_ID'
    ];

    public function nombre()
    {
        return $this->MP_IEPRO_NOMBRE;
    }
    public function id()
    {
        return $this->MP_IEPRO_ID;
    }
    public function referencia()
    {
        return $this->MP_IEPRO_REFERENCIA;
    }
}
