<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuloSistema extends Model
{
    protected $table = 'MP_MODULOS_SISTEMA';
    protected $primaryKey = 'MP_MODULOS_SISTEMA_ID';
    public $timestamps = false;

    protected $fillable = [
        'MP_MODULOS_SISTEMA_ID',
        'MP_NOMBRE_MODULO',
        'MP_NOMBRE_SUBMODULO',
        'MP_OBSERVACIONES'
    ];

    protected $hidden = [
    ];

    public function id()
    {
        return $this->MP_MODULOS_SISTEMA_ID;
    }

    public function nombre()
    {
        return $this->MP_NOMBRE_MODULO;
    }
    public function subModulo()
    {
        return $this->MP_NOMBRE_SUBMODULO;
    }
    public function observaciones()
    {
        return $this->MP_OBSERVACIONES;
    }

}
